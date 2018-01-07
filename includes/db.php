<?php
//File used to create connection to database for unauthorised users

//Store values for connection in an array
    $db_host = "localhost";
    $db_user = "samfrancis";
    $db_pass = "password";
    $db_name  = "datbaseassinment";

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


<?php
//Client external database 
//Store values for connection in an array
  //  $db_host2 = "flexelearning.com";
	//$db_name2  = "flexeweb_cafe";
    //$db_user2 = "flexe_student";
    //$db_pass2 = "B@thCollege";

// Create connection
//$connection2 = new mysqli($db_host2, $db_user2, $db_pass2 , $db_name2);

// Check connection
//if ($connection2->connect_error) {
 //   die("Connection failed: " . $connection2->connect_error);
//
//}
  // $connection2->set_charset("utf-8");//Set charset to english

?>