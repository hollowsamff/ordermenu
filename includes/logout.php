<?php  include "db.php";
//Page used to logout to the site - uses buttion in CMS section of site
session_start();
	 
	
    //Remove old SESSIONs
	
    $_SESSION['user_first_name'] = null  ;
	$_SESSION['user_last_name']= null ;
    $_SESSION['user_role'] = null;
	$_SESSION['user_name']= null ;	
	
	session_unset(); 
	session_destroy(); 
	
    header("Location:  ../index.php");


?>
          

      