<?php
session_start();
require_once "../config/database.php";

// Vérifier si c'est une requête POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../inscription.html?error=missing");
    exit();
}

// Récupérer et valider les données
$nom = isset($_POST['nom']) ? sanitize($_POST['nom']) : '';
$prenom = isset($_POST['prenom']) ? sanitize($_POST['prenom']) : '';
$email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

// Vérifier champs obligatoires
if(empty($nom) || empty($prenom) || empty($email) || empty($password)){
    header("Location: ../inscription.html?error=missing");
    exit();
}

// Vérifier format email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("Location: ../inscription.html?error=invalid_email");
    exit();
}

// Vérifier correspondance des mots de passe
if($password !== $password_confirm){
    header("Location: ../inscription.html?error=passwords_match");
    exit();
}

// Vérifier force du mot de passe (8+ chars, 1 majuscule, 1 chiffre)
if(strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password)){
    header("Location: ../inscription.html?error=weak_password");
    exit();
}

// Vérifier si email existe déjà
$conn = connectDB();
$stmt = $conn->prepare("SELECT id FROM lecteurs WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $stmt->close();
    $conn->close();
    header("Location: ../inscription.html?error=email_exists");
    exit();
}

// Hasher le mot de passe
$hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

// Insérer le nouvel utilisateur
$stmt = $conn->prepare("INSERT INTO lecteurs (nom, prenom, email, mot_de_passe, actif) VALUES (?, ?, ?, ?, TRUE)");
$stmt->bind_param("ssss", $nom, $prenom, $email, $hashed_password);

if($stmt->execute()){
    $stmt->close();
    $conn->close();
    // REDIRECTION VERS CONNEXION AVEC MESSAGE
    header("Location: ../connexion.html?success=registered");
    exit();
} else {
    $error = $stmt->error;
    $stmt->close();
    $conn->close();
    header("Location: ../inscription.html?error=missing");
    exit();
}
?>
