<?php  session_start();
include "db.php";
include "../admin/functions.php";

//Page used to login to the site - data is sent from the sidebar.php include 

 if(isset($_POST['login'])) {	 

login_user($_POST['username'], $_POST['password'] );//Load function to login user
			

 }
 
?>

