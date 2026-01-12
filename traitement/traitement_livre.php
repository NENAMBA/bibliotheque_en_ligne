<?php
include '../config/database.php';
$conn = connectDB();

$titre = $_GET['titre'];
$auteur = $_GET['auteur'];
$description = $_GET['description'];
$maison_edition = $_GET['maison_edition'];
$nombre_exemplair = $_GET['nombre_exemplair'];

 $chck_sql = "SELECT * FROM `livres` WHERE 1";
mysqli_query($conn, $chck_sql);

$sql = "INSERT INTO livres ( id, titre, auteur, description, maison_edition, nombre_exemplair)
 values (NULL, '$titre', '$auteur', '$description', '$maison_edition', '$nombre_exemplair')";  

mysqli_query($conn, $sql);
  
echo "le livre a été ajouté avec succès!";


?>  