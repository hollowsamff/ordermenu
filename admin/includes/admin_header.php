<?php ob_start(); //Output buffering - needed when the page is redirecting bits of code to another page(makea it send the data  in one go)
include"../includes/db.php"; //Database connection include
include"functions.php";
session_start();

//Test if user has a Admin role - only Admins can access the the database CMS pages

//Test if SESSION is set
if(!isset($_SESSION['user_role'])){
	
		header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Allan Cafe</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
  	<link href="css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--Google charts -->	
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
	<!--https://www.tinymce.com/ frame work. used to add customisation to text area boxes -->	
	<script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=22kf8vr11vj4d9yu9elcwa5kd1m2yith5akuv3gu8cb3sgug"></script>
	<!-- jQuery -->
    <script src="js/jquery.js"></script>
	
</head>

<body>
