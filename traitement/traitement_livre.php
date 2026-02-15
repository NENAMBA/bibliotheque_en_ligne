<?php
session_start();
require_once "../config/database.php";

// Vérifier si c'est une requête POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../ajout_livre.html?error=missing");
    exit();
}

// Récupérer et valider les données texte
$titre = isset($_POST['titre']) ? sanitize($_POST['titre']) : '';
$auteur = isset($_POST['auteur']) ? sanitize($_POST['auteur']) : '';
$genre = isset($_POST['genre']) ? sanitize($_POST['genre']) : '';
$maison_edition = isset($_POST['maison_edition']) ? sanitize($_POST['maison_edition']) : '';
$isbn = isset($_POST['isbn']) ? sanitize($_POST['isbn']) : '';
$date_publication = isset($_POST['date_publication']) ? sanitize($_POST['date_publication']) : '';
$nombre_exemplair = isset($_POST['nombre_exemplair']) ? intval($_POST['nombre_exemplair']) : 1;
$prix = isset($_POST['prix']) ? floatval($_POST['prix']) : 0.00;
$description = isset($_POST['description']) ? sanitize($_POST['description']) : '';

// Vérifier les champs obligatoires
if(empty($titre) || empty($auteur) || empty($genre)){
    header("Location: ../ajout_livre.html?error=missing");
    exit();
}

$image_couverture = '';

// Traiter l'upload de l'image si présent
if(!empty($_FILES['image_couverture']['name'])){
    $file = $_FILES['image_couverture'];
    
    // Vérifier les erreurs d'upload
    if($file['error'] !== UPLOAD_ERR_OK){
        header("Location: ../ajout_livre.html?error=upload_failed");
        exit();
    }
    
    // Vérifier la taille (5MB)
    if($file['size'] > 5242880){
        header("Location: ../ajout_livre.html?error=file_too_large");
        exit();
    }
    
    // Vérifier le type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp'];
    if(!in_array($mime, $allowed_mimes)){
        header("Location: ../ajout_livre.html?error=invalid_file");
        exit();
    }
    
    // Générer un nom de fichier sécurisé
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $image_couverture = uniqid('livre_') . '_' . time() . '.' . $ext;
    
    // Créer le dossier s'il n'existe pas
    $upload_dir = "../images/couvertures/";
    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0755, true);
    }
    
    // Déplacer le fichier
    if(!move_uploaded_file($file['tmp_name'], $upload_dir . $image_couverture)){
        header("Location: ../ajout_livre.html?error=upload_failed");
        exit();
    }
}

// Insérer le livre dans la base de données
$conn = connectDB();
$stmt = $conn->prepare("
    INSERT INTO livres 
    (titre, auteur, description, maison_edition, nombre_exemplair, image_couverture, genre, isbn, date_publication, prix) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssissssd",
    $titre,
    $auteur,
    $description,
    $maison_edition,
    $nombre_exemplair,
    $image_couverture,
    $genre,
    $isbn,
    $date_publication,
    $prix
);

if($stmt->execute()){
    $book_id = $stmt->insert_id;
    $stmt->close();
    $conn->close();
    
    // Redirection avec succès
    header("Location: ../ajout_livre.html?success=book_added&id=" . $book_id);
    exit();
} else {
    // Si l'insertion échoue et qu'une image a été uploadée, la supprimer
    if(!empty($image_couverture) && file_exists("../images/couvertures/" . $image_couverture)){
        unlink("../images/couvertures/" . $image_couverture);
    }
    
    $stmt->close();
    $conn->close();
    
    header("Location: ../ajout_livre.html?error=missing");
    exit();
}
?>
