<?php
//File used to create connection to database for unauthorised users

//Store values for connection in an array
  $db_host = "localhost";
    $db_user = "";
    $db_pass = "";
    $db_name  = "datbaseassinment";


// Create connection
$connection = new mysqli($db_host, $db_user, $db_pass , $db_name);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);

}
   $connection->set_charset("utf-8");//Set charset to english
   
  
   
?>