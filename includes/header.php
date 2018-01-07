<?php
ob_start();
session_start();
include "admin/functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Menu creation contact managment system</title>
    <!-- Custom CSS -->
    <link href="css/blog-home.css" rel="stylesheet">
	
    <!-- Bootstrap Core CSS -->
	<link href="admin/css/bootstrap.css" rel="stylesheet">
    <link href="admin/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>

<!--Over ride bootstrap style-->
 <style>
 
 @media(min-width:800px) {
.container-fluid{	
	padding-left:100px;	
  }	
}

 </style>
<body>