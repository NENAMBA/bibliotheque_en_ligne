<?php
include "../config/database.php";
$conn = connectDB();

$sql = "SELECT * FROM livres ";

$result = mysqli_query($conn, $sql);




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./../CSS/style.css">
</head>
<body>



<div class="livre-container">
    <?php
       if($result && $result->num_rows > 0){
    while($row  = $result->fetch_assoc()){
        ?>

       <div class="livre-card">
         <img src="./../images/book success.jpg"  height="300px"  alt="image du livre">
         <p> <?php echo $row['titre']."<br>"; ?>  </p>
         <p> <?php echo $row['auteur']."<br>"; ?>  </p>
          <!-- <button><?php echo "<img src='./../images/images.png' alt='Modifier' width='20px'>"; ?></button> -->
         <!-- <button><?php echo "<a href='../traitement/supression_livre.php?id=" . $row['id'] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce livre ?\")'>Supprimer</a>"; ?></button> --> 

         <div class="btn-livre">
    <div> 
     <form   action="../traitement/supression_livre.php" method="POST" onsubmit="return confirm('Etes_vous sur de vouloir suprimer ce livre ?')">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <button  type="submit"><img src="./../images/deleter.png" alt="suprimer" width=30px></button>
     </form>
    </div>
    
     <div>
        <form>
       <button class="btn-modifier"  type="submit"><img src="./../images/images.png" alt="modifier" width=30px></button>
        </form>
    
    </div>
         </div>

</div> 
       <!-- <div>
         <img src="./images/book1.jpg"  height="300px"  alt="image du livre">
         <p> <?php echo $row['titre']."<br>"; ?>  </p>
         <p> <?php echo $row['auteur']."<br>"; ?>  </p>
         <p> <?php echo $row['description']."<br>"; ?>  </p>
         <p> <?php echo $row['maison_edition']."<br>"; ?>  </p>
         <p> <?php echo $row['nombre_exemplair']."<br>"; ?>  </p>
    </div> -->
       

        <?php
    }
}

?>






</div>


    
</body>
</html>