<?php

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
    </div>
       

        <?php
    }
}

?>






</div>


    
</body>
</html>