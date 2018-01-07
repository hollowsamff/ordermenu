<!--Fix error when link color is not changing in Chrome web browswer-->
<style>
.navbar-inverse .navbar-nav>li>a {
    color: #ffffff!important;
}
.navbar-inverse .navbar-brand {
     color: #ffffff!important;
}

 .navbar-toggle {
    margin-left: 15px!important;
    padding: 0px 0px!important;
    float: left!important;
}

.move {
 margin:0px 15px 0px 0px!important;
 padding: 0px 5px 0px 0px!important;

}

@media(max-width:750px) {
  .move {


}
	
}


</style>

  <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
				</button> 

                <a class= "navbar-brand " href='index.php' href="index.php">Home</a>

                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
			
				 <li class='<?php echo  $about_us_class;?>'><a href="registration.php">Registration</a></li>
				<?php


					$registration_class = '';//Used for static links
					$index_class = '';//Used for static links							
					$page_name = basename($_SERVER['PHP_SELF']);//Find name of current page
					$registration = 'registration.php'; //Names of static links
					$index = 'index.php'; //Names of static links
				
	
				?>
					     <?php //If user is logged in show link to the currently showing post page in navigation bar 
						 if(isset($_SESSION['user_id'])){
							 						 
							 echo" <li><a href='admin/index.php'>Shop CMS</a></li>";

						 }
						 
						 ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<!--Code used to change the color of the active webpage-->
<style>
nav a.current {
	
  background-color:#3CB371;

}

</style>

<script>
$(function(){
  $('a').each(function() {
    if ($(this).prop('href') == window.location.href) {
      $(this).addClass('current')
  }
  });
});
</script>