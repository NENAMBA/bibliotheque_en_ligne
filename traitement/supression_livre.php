<?php
include '../config/database.php';

    $conn = connectDB();
    $id = $_POST['id'];

    $sql = "DELETE FROM livres WHERE id = $id";

    $result = mysqli_query($conn, $sql);
    

    echo "le livre a été suprimer avec succês!"

    
?>