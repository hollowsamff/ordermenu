<?php
//Page header include  page is used to login to the sites CMS - page use case to show differnt content from includes
include"includes/admin_header.php";//Page used to load all the drink includes baseded pages 


//If the function that tests if a user is admin sents back false
if(!is_admin()){

	header("Location: profile.php");//Only profile user can only acess the profile.php page 
}
	

?>
    <div id="wrapper">

	
	
	 <!-- Navigation -->
	 <?php include"includes/admin_navigation.php";//Page navigation include ?>
	
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
				
                    <div class="col-lg-12">
					
					    <h1 class="page-header text-center">Drinks</h1>
					
					
					<?php

					if(isset($_GET['source'])){
						
						$source = $_GET['source'];
						
					}else{
						
						$source = ' ';
					}
				
					switch($source){
						
						case 'add_drink';
						
							include "includes/add_drink.php";//Load page that is used to add new drink
							
						break;
						
						
						case 'edit_drink';
						
							include "includes/edit_drink.php";//Load page that is used to edit drink
							
						break;
							
						default:
						
						include "includes/view_all_drinks.php";//Show all the drinks from database
					
						break;
						
					}
					
					
					
					
					?>

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>	
		
<?php include"includes/admin_footer.php";//Page footer include ?>