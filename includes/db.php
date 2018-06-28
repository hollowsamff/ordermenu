<?php
//File used to create connection to database for unauthorised users

//Store values for connection in an array - change this to the hostname,usename and password of the database
    $db_host = "localhost";
    $db_user = "samfrancis";
    $db_pass = "password";
    $db_name  = "menusystem";

//Covert valus from array to constants(all uppercase letters)
//foreach($db as $key => $value){	
	//define(strtoupper($key), $value);//$key is used to uppercase the values
	//$key is equal to $db values: e.g. in $db["db_host"] db_host is the key	
//}

// Create connection
$connection = new mysqli($db_host, $db_user, $db_pass , $db_name);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);

}
   $connection->set_charset("utf-8");//Set charset to english
 
?>




