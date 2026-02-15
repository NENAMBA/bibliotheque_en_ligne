<?php
// Ce fichier n'est plus utilisé. La récupération des livres est faite directement dans index.php
// pour optimiser les performances et la structure du code.
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>



<div class="livre-container">
<?php
if($result && $result->num_rows > 0){
    while($row  = $result->fetch_assoc()){
        ?>

       <div class="livre-card">
         <img src="./images/book success.jpg"  height="220px"  alt="image du livre">
         <p> <?php echo $row['titre']."<br>"; ?>  </p>
         <p> <?php echo $row['auteur']."<br>"; ?>  </p>
         <!-- <p> <?php echo $row['description']."<br>"; ?>  </p> -->

         <button type="button" class="detail-livre"> <a href="details.php"> Détails</a></button>
    </div>
       

        <?php
    }
}

?>






</div>


    
</body>
</html>