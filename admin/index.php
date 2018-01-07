<?php 
//Page header include
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
                        <h1 class="page-header">
                             Welcome to your  shops content managment system <small> <?php echo $_SESSION['user_first_name']." ".$_SESSION['user_last_name'];?> </small> 
                        </h1>
                    </div>
				
                </div>
                <!-- /.row -->
       
                <!-- /.row -->
	
				<div class="row">
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-file-text fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
				
									   <!-- /.Number of posts in database - uses function from functions.php  -->	
									   <div class='huge'><?php echo $menu = record_count('food_menu');?> </div>
							
										<div>Food Menu items</div>
									</div>
								</div>
							</div>							
							<a href="menu.php">
								<div class="panel-footer">
									<span class="pull-left">View Food Menu</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					
	
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-comments fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
								
									<!-- /.Number of comments in database - uses function from functions.php  -->	
									<div class='huge'><?php  echo $meals = record_count('meal'); ?> </div>
					
									  <div>Meals</div>
									</div>
								</div>
							</div>
							<a href="meals.php">
								<div class="panel-footer">
									<span class="pull-left">View Meals</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
						
						<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-comments fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
								
									<!-- /.Number of comments in database - uses function from functions.php  -->	
									<div class='huge'><?php  echo $meal_type = record_count('meal_type'); ?> </div>
					
									  <div>Meal types</div>
									</div>
								</div>
							</div>
							<a href="meal_categories.php">
								<div class="panel-footer">
									<span class="pull-left">View Meal Types</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>						
						<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-comments fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
								
									<!-- /.Number of comments in database - uses function from functions.php  -->	
									<div class='huge'><?php  echo $meal_categories = record_count('meal_category'); ?> </div>
					
									  <div>Meal Categories</div>
									</div>
								</div>
							</div>
							<a href="meal_categories.php">
								<div class="panel-footer">
									<span class="pull-left">View Meal Categories</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
	          		<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-user fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
									
								       <!-- /.Number of users in database - uses function from functions.php  -->	
									   <div class='huge'><?php echo $user_count = record_count('allergy');?> </div>
									   
										
										 <div>Meal Allergies</div>
									</div>
								</div>
							</div>
							
							<a href="allergys.php">
								<div class="panel-footer">
									<span class="pull-left">View Meal Allergies</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					
						<div class="col-lg-3 col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-user fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
									
								       <!-- /.Number of users in database - uses function from functions.php  -->	
									   <div class='huge'><?php echo $user_count = record_count('drink_menu');?> </div>
									   										
										 <div>Drink Menu items</div>
									</div>
								</div>
							</div>					
							<a href="drink_menu.php">
								<div class="panel-footer">
									<span class="pull-left">View Drink Menu</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					<div class="row">
					
					<div class="col-lg-3 col-md-6">
						<div class="panel panel-green">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-file-text fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
				
									   <!-- /.Number of posts in database - uses function from functions.php  -->	
									   <div class='huge'><?php echo $menu = record_count('drinks');?> </div>
							
										<div>Drinks</div>
									</div>
								</div>
							</div>							
							<a href="drinks.php">
								<div class="panel-footer">
									<span class="pull-left">View Drinks</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
							
                        <div class="col-lg-3 col-md-6">
						<div class="panel panel-red">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-file-text fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
				
									   <!-- /.Number of posts in database - uses function from functions.php  -->	
									   <div class='huge'><?php echo $menu = record_count('orders');?> </div>
							
										<div>Shop Transactions</div>
									</div>
								</div>
							</div>							
							<a href="orders.php?source=view_all_orders">
								<div class="panel-footer">
									<span class="pull-left">View Orders</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
					    
						<div class="col-lg-3 col-md-6">
						<div class="panel panel-red">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-file-text fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
				
									   <!-- /.Number of posts in database - uses function from functions.php  -->	
									   <div class='huge'><?php echo $menu = record_count('drink_order_drinks');?> </div>
							
										<div>Sold Drink Items</div>
									</div>
								</div>
							</div>							
							<a href="orders.php?source=add_drink_order">
								<div class="panel-footer">
									<span class="pull-left">Order Drinks</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
							<div class="col-lg-3 col-md-6">
						<div class="panel panel-red">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-file-text fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
				
									   <!-- /.Number of posts in database - uses function from functions.php  -->	
									   <div class='huge'><?php echo $menu = record_count('meal_order_meals');?> </div>
							
										<div>Sold Food Items</div>
									</div>
								</div>
							</div>							
							<a href="orders.php?source=add_meal_order">
								<div class="panel-footer">
									<span class="pull-left">Order Food</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
			
			
				<div class="col-lg-3 col-md-6">
						<div class="panel panel-yellow">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-list fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
									
									     <!-- /.Number of categories in database - uses function from functions.php  -->	
									     <div class='huge'><?php echo $orders_count = record_count('users');?> </div>
									   
										<div>Website Users</div>
									</div>
								</div>
							</div>
							<a href="users.php">
								<div class="panel-footer">
									<span class="pull-left">View Website Users</span>
									<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
									<div class="clearfix"></div>
								</div>
							</a>
						</div>
					</div>
				</div>
			
			
			   <!-- /.row -->
			   <?php 
    ?>
                
	<!--<div class="row">
			<?php
			//Querys to find values to show in google charts on the admin index.php page - shows chart number 
			//Use function to find values to show in charts		
			//$subscriber_user_count =  check_status('users','user_role','Subscriber');		   		
											
			?>	
		   <script type="text/javascript">
		   google.charts.load('current', {'packages':['bar']});
		   google.charts.setOnLoadCallback(drawChart);
					  
		  function drawChart() {
			var data = google.visualization.arrayToDataTable([['Data', 'Count'],
				
				<?php //Non static update loop				
     					  //Hold  and print the differt charts names
						 // $element_text = [ 'Draft Posts', 'Published Posts',  'Approved Comments','Pending Comments','Website Accounts','Blog Categories'];
						  //Hold and print the number in each chart 
						  //$element_count = [$user_count, $orders_count];
						  
						  ///for($i = 0;$i < 1; $i++){ //Show the charts - thier are four: posts, users, comments and categories 
						  
							 // echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";	 
						  //}										
				?>
				   
		 
			]);

			var options = {
			  chart: {
				title: '',
				subtitle: '',
				
			  }
		
			};

			var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

			chart.draw(data, options);
		  }
		</script>
					   
		<div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
	 
	 </div>-->

	</div>
	<!-- /.container-fluid -->

</div>
     
	 
<?php include"includes/admin_footer.php";//Page footer include ?>