<?php
session_start();
require_once "../config/database.php";

// Vérifier authentification
if(!isLoggedIn()){
    header("Location: ../connexion.html");
    exit();
}

// Vérifier méthode POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../index.php");
    exit();
}

// Récupérer les données
$livre_id = isset($_POST['livre_id']) ? intval($_POST['livre_id']) : 0;
$action = isset($_POST['action']) ? sanitize($_POST['action']) : '';

if($livre_id <= 0 || empty($action) || !in_array($action, ['add', 'remove'])){
    header("Location: ../index.php");
    exit();
}

// Vérifier que le livre existe
$conn = connectDB();
$stmt = $conn->prepare("SELECT id FROM livres WHERE id = ?");
$stmt->bind_param("i", $livre_id);
$stmt->execute();

if($stmt->get_result()->num_rows === 0){
    $stmt->close();
    $conn->close();
    header("Location: ../index.php");
    exit();
}

$stmt->close();

// Traiter l'action
if($action === 'add'){
    // Ajouter à la wishlist (INSERT IGNORE pour éviter les doublons)
    $stmt = $conn->prepare("INSERT IGNORE INTO wishlists (lecteur_id, livre_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $_SESSION['user_id'], $livre_id);
    $stmt->execute();
    $stmt->close();
} else if($action === 'remove'){
    // Retirer de la wishlist
    $stmt = $conn->prepare("DELETE FROM wishlists WHERE lecteur_id = ? AND livre_id = ?");
    $stmt->bind_param("ii", $_SESSION['user_id'], $livre_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirection vers la page précédente ou vers details.php
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';

// Éviter les redirections infinies
if(strpos($referer, 'traitement') !== false){
    $referer = '../details.php?id=' . $livre_id;
}

header("Location: " . $referer);
exit();
?>
