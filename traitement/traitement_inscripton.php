<?php
include '../config/database.php';
$conn = connectDB();

$nom = $_GET['nom'];
$prenom = $_GET['prenom'];
$email = $_GET['email'];


$sql = "INSERT INTO lecteurs (id, nom, prenomn, email) values (NULL, '$nom', '$prenom', '$email')";  

mysqli_query($conn, $sql);
  
echo "Inscription reussie avec succes!";


?>