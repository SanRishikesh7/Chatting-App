<?php 
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chatapp";
  
  $conn = mysqli_connect("localhost", "root", "", "chatapp");
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }

?>