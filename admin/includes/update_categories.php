        <!-- Update meal category POST data form-->
		<form action= "" method = "post">
			<div class = "form-group">
			<label for="cat_title">Update Meal Category</label>
			
				<?php
					   //Used to show text box which is used to edit the categories from database categories table - activate when edit button is pressed
					   if(isset($_GET['edit'])){
						   
							$cat_id = escape($_GET['edit']);//Value send from the Edit button
						   
						     //Find all the categories from database categories table where the cat_id is equal to the send value
						     $stmt = mysqli_prepare($connection,"SELECT meal_category_id, meal_category_name FROM  meal_category WHERE meal_category_id = ?");
							 mysqli_stmt_bind_param($stmt,'i', $cat_id );
							 mysqli_stmt_execute($stmt);
							 $stmt->bind_result($cat_id , $cat_title);

							//Show all the categories from database categories table 
							 while($stmt->fetch()){
								 
								$cat_id = $cat_id;
								$cat_title = $cat_title;
			   ?>
			
			<input value ="<?php if(isset($cat_title)){echo $cat_title;}?>"type = "text" class = "form-control"  name = "cat_title">
			
   <?php } }
				  mysqli_stmt_close($stmt);//Close statment
				
   ?>
   
		 <?php
		 
			//Code runs after the Current Categories table update button is pressed and the Update category show edit box code runs
			//Update query update_category POST is sent from Update category POST data form
			if(isset($_POST['update_category'])){//If user has sent a value useing the Update category form run the code
			 
			 $the_cat_title = $_POST['cat_title'];

			if($the_cat_title == "" || empty($the_cat_title)){//Test if the value is blank
			  
				echo"<h4 class='warning_red'>Add Category shoud not be empty!</h4>";
				
			}else{//Insert value into database categories table
				
			//Keep same value if user makes no changes
			//Use function to test if the category exists
			//Use function to test if the category exists
			if ($the_cat_title  != $cat_title  and  categories_exists($the_cat_title) !== false){
				
				echo"<h4 class='warning_red'>Meal Catagory already exists!</h4>";

			}else{

				 $stmt = mysqli_prepare($connection,"UPDATE meal_category SET meal_category_name = ? WHERE meal_category_id  = ?");
				 //Update the categories with the same id as the update button which was pressed
				 mysqli_stmt_bind_param($stmt,'si',$the_cat_title, $cat_id );
				 mysqli_stmt_execute($stmt);
				 mysqli_stmt_close($stmt);//Close statment
				 mysqli_stmt_close($connection);//Close database
				 redirect("meal_categories.php");
			   }						 
			}
		 }
			?>

			</div>
			<div class = "form-group">
			<input class = "btn btn-primary" type = "submit" name = "update_category" value="Update Meal Category">
			</div>
			
		</form><!-- Update category POST data form end -->