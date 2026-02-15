<?php
session_start();
require_once "./config/database.php";

initializeDatabase();

// Récupérer l'ID du livre et l'action
$livre_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$action = isset($_GET['action']) ? sanitize($_GET['action']) : 'read';

if($livre_id <= 0){
    header("Location: index.php");
    exit();
}

// Récupérer les détails du livre
$conn = connectDB();
$stmt = $conn->prepare("SELECT * FROM livres WHERE id = ?");
$stmt->bind_param("i", $livre_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}

$book = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Vérifier si le PDF existe
$pdf_path = "pdfs/" . $book['pdf_file'];
if(!file_exists($pdf_path)){
    header("Location: details.php?id=$livre_id&error=no_pdf");
    exit();
}

// Gérer l'action
if($action === 'download'){
    // Télécharger le PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . htmlspecialchars($book['titre']) . '.pdf"');
    header('Content-Length: ' . filesize($pdf_path));
    readfile($pdf_path);
    exit();
} else {
    // Afficher le PDF en ligne
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . htmlspecialchars($book['titre']) . '.pdf"');
    readfile($pdf_path);
    exit();
}
?>
