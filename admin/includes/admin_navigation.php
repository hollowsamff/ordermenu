<!--Fix error when link color is not changing in Chrome web browswer-->
<style>
.navbar-inverse .navbar-nav>li>a {
    color: #ffffff!important;
}
.navbar-inverse .navbar-brand {
     color: #ffffff!important;
}
.top-nav>li>a {
    color: #ffffff!important;
}
.side-nav>li>ul>li>a {
   color: #ffffff!important;
}
</style>


        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->

			<div class="navbar-header">
			
			    <?php //Nav bar for the subscriber user
							 if($_SESSION['user_role'] == 'Subscriber'){
							 
								 echo "<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-ex1-collapse'>";
								 echo" <span class='sr-only'>Toggle navigation</span>";
								 echo" <span class='icon-bar'></span>";
								 echo"<span class='icon-bar'></span>";
								 echo"<span class='icon-bar'></span>";
								 echo" </button>";
								 echo"</div>";
														 
							      //<!-- Top Menu Items -->
								  echo"<ul class='nav navbar-right top-nav'>";
	
								 echo "</ul>";
								 //Sidebar Menu Items - These collapse to the responsive navigation menu on small screens 
								 echo"<div class='collapse navbar-collapse navbar-ex1-collapse'>";
								 echo "<ul class='nav navbar-nav side-nav'>";
									
								 echo "<li><a href='../index.php'>Home Page</a></li>";	
								 echo"<li><a href='../includes/logout.php'><i class='fa fa-fw fa-power-off'></i> Log Out</a></li>";
										 
								 echo"</ul>";
								 echo" </div>";
								 //<!-- /.navbar-collapse -->
									
                                 echo "</nav>";
								 
								 return;
							 }else{	}?>
							 
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Admin</a>
				
            </div>
			
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
 
			 <li><a href="../index.php">Home Page</a></li>	
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  
					<?php 
					
					if(isset($_SESSION['user_name'])){
					
					echo $_SESSION['user_name'];
					
					}
					
					?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
					
                        <!-- <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>-->
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>	
                    </ul>
                </li>
            </ul>
			
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
					
					  
												<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#menu_dropdown"><i class="fa fa-fw fa-arrows-v"></i>Menus<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="menu_dropdown" class="collapse">
								   <li>
									<a href="menu.php"><i class="fa fa-fw fa fa-cutlery"></i>Food Menu</a>
								  </li>
								  
								  <li>
									<a href="drink_menu.php"><i class="fa fa-fw fa fa-beer"></i>Drink Menu</a>
								  </li>
                        </ul>
                        </li>
						
		
						<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#meals_dropdown"><i class="fa fa-fw fa-arrows-v"></i>Menu Meals<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="meals_dropdown" class="collapse">
                            <li>
                                <a href="./meals.php">View All Meals</a>
                            </li>
                            <li>
                                <a href="meals.php?source=add_meal">Add Meal</a>
                            </li>					
							<li>
                                <a href="meal_categories.php">Meal Categories / Types</a>
                            </li>
							    <li>
                                <a href="./allergys.php">Meals Allergies</a>
                            </li>

                        </ul>
                        </li>

						<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#drinks_dropdown"><i class="fa fa-fw fa-arrows-v"></i>Menu Drinks<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="drinks_dropdown" class="collapse">
                            <li>
                                <a href="./drinks.php">View All Drinks</a>
                            </li>
                            <li>
                                <a href="drinks.php?source=add_drink">Add Drink</a>
                            </li>
							
							<li>
                                <a href="drink_categories.php">Drink Categories</a>
                            </li>
                        </ul>
                        </li>
					
	
						<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#POS_dropdown"><i class="fa fa-fw fa-arrows-v"></i>POS<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="POS_dropdown" class="collapse">
                            <li>
                                <a href="orders.php?source=view_all_orders">View All Orders</a>
                            </li>
                            <li>
                                <a href="orders.php?source=add_meal_order">Add Meal Order</a>
                            </li>
                             <li>
                                <a href="orders.php?source=add_drink_order">Add Drink Order</a>
                            </li>							
                        </ul>
                        </li>
					
				
			 	<li>
				
				<!--
                        <a href="./index_CMS.php"><i class="fa fa-fw fa-dashboard"></i>Suppliers</a>
                    </li>
					
					 	<li>
                        <a href="./index_CMS.php"><i class="fa fa-fw fa-dashboard"></i>Stock</a>
                        </li>
				
                   	<li>
					
					-->
                        <a href="./index_CMS.php"><i class="fa fa-fw fa-dashboard"></i> Website Index Page CMS</a>
                    </li>
					
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#comments_dropdown"><i class="fa fa-fw fa-arrows-v"></i>Website User Accounts<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="comments_dropdown" class="collapse">
                            <li>
                                <a href="./users.php">View All Users</a>
                            </li>
                            <li>
                                <a href="users.php?source=add_users">Add Users</a>
                            </li>
							<li>
                                <a href="profile.php"><i class="fa fa-fw  fa-user"></i> Profile</a>
                            </li>
							
                        </ul>
                    </li>
									
					<li>

					
                    </li>
		
                </ul>
            </div>
            <!-- /.navbar-collapse -->
			
        </nav>	
		
		
		<?php?>
		
		