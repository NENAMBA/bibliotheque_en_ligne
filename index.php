<?php
include "./config/database.php";

// connectDB();





?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    
    


<div class="container">
    <div class="inscrit">
        <h2>  LA LECTURE NOUS OUVRE A L'INCONNU !</h2>
        <p>
            Ouvrire un livre c'est commencer un voyage memorable !!
  
        </p>
        <button type="submit" class="btn-premier"><a href="inscription.html">Inscription</a></button>
        
        <button type="submit" class="btn-seconde"><a href= "ajout_livre.html">Ajouter le livre</a></button>
    </div>
    <figure>
        <img src="./images/GOALS.jpg" width="500">
    </figure>

</div>

<section id="livres" class="livres">
    <div class="search-bar">
<h2>Nos livres disponibles</h2>
<input type="text" id="searchInput" placeholder="rechercher un livre..." onkeyup="searchBooks()">
<button onclick="searchBooks()">Rerchercher</button>
</div>
    <?php include "./recuperation/recuperation_livre.php"; ?>
</section>







</body>
</html>