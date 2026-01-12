<?php

function connectDB(){

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_bibliotheque');


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($conn === false){
    die("error: db not connected". $conn->connect_error());
}else{
    //  echo "db connected successully";
}

return $conn;
}
















?>