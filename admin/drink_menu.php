<?php //Page is used to control the drink menu - page use case to show differnt content from includes
include"includes/admin_header.php";

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
					
					    <h1 class="page-header text-center">Drink Menu</h1>
					    
					
					<?php

					if(isset($_GET['source'])){
						
						$source = $_GET['source'];
						
					}else{
						
						$source = ' ';
					}
				
					switch($source){
						
						case 'drink_menu_select';
						
							include "includes/view_all_drinks.php";//Show all the meal from database
					
						break;
					
							
						default:
									
					       include "includes/drink_menu_select.php";//Load page that is used to add new meal
							
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



















