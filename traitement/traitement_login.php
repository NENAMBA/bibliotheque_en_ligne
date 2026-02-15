<?php
session_start();
require_once "../config/database.php";

// Vérifier si c'est une requête POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../connexion.html?error=missing");
    exit();
}

// Récupérer et valider les données
$email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Vérifier champs obligatoires
if(empty($email) || empty($password)){
    header("Location: ../connexion.html?error=missing");
    exit();
}

// Vérifier format email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("Location: ../connexion.html?error=invalid");
    exit();
}

// Rechercher l'utilisateur
$conn = connectDB();
$stmt = $conn->prepare("SELECT id, prenom, mot_de_passe FROM lecteurs WHERE email = ? AND actif = TRUE");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    $stmt->close();
    $conn->close();
    header("Location: ../connexion.html?error=invalid");
    exit();
}

// Vérifier le mot de passe
$user = $result->fetch_assoc();
if(!password_verify($password, $user['mot_de_passe'])){
    $stmt->close();
    $conn->close();
    header("Location: ../connexion.html?error=invalid");
    exit();
}

// Créer la session
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $email;
$_SESSION['user_prenom'] = $user['prenom'];
$_SESSION['login_time'] = time();

// Gestion du "remember me" optionnel (pas implémenté en DB ici)
if(isset($_POST['remember']) && $_POST['remember'] === 'on'){
    // Optionnel: créer un cookie long terme
    // setcookie('remember_token', ..., time() + 30*24*60*60, '/');
}

$stmt->close();
$conn->close();

// REDIRECTION VERS INDEX (PAGE D'ACCUEIL)
header("Location: ../index.php");
exit();
?>
