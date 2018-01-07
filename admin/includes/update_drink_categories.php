        <!-- Update drink category POST data form-->
		<form action= "" method = "post">
			<div class = "form-group">
			<label for="drink_title">Update Drink Category</label>
			
				<?php
					   //Used to show text box which is used to edit the categories from database categories table - activate when edit button is pressed
					   if(isset($_GET['edit'])){
						   
							$drink_id = escape($_GET['edit']);//Value send from the Edit button
						   
						     //Find all the categories from database categories table where the drink_id is equal to the send value
						     $stmt = mysqli_prepare($connection,"SELECT drink_category_id, drink_category_name FROM  drink_category WHERE drink_category_id = ?");
							 mysqli_stmt_bind_param($stmt,'i', $drink_id );
							 mysqli_stmt_execute($stmt);
							 $stmt->bind_result($drink_id , $drink_title);

							//Show all the categories from database categories table 
							 while($stmt->fetch()){
								 
								$drink_id = $drink_id;
								$drink_title = $drink_title;
			   ?>
			
			<input value ="<?php if(isset($drink_title)){echo $drink_title;}?>"type = "text" class = "form-control"  name = "drink_title">
			
   <?php } }
				  mysqli_stmt_close($stmt);//Close statment
				
   ?>
   
		 <?php
		 
			//Code runs after the Current Categories table update button is pressed and the Update category show edit box code runs
			//Update query update_category POST is sent from Update category POST data form
			if(isset($_POST['update_category'])){//If user has sent a value useing the Update category form run the code
			 
			 $the_drink_title = $_POST['drink_title'];

			if($the_drink_title == "" || empty($the_drink_title)){//Test if the value is blank
			  
				echo"<h4 class='warning_red'>Drink Catagory shoud not be empty!</h4>";
				
			}else{//Insert value into database categories table
				
			//Keep same value if user makes no changes
			//Use function to test if the category exists
			//Use function to test if the category exists
			if ($the_drink_title  != $drink_title  and  drink_categories_exists($the_drink_title) !== false){
				
				echo"<h4 class='warning_red'>Drink catagory already exists!</h4>";

			}else{

				 $stmt = mysqli_prepare($connection,"UPDATE drink_category SET drink_category_name = ? WHERE drink_category_id  = ?");
				 //Update the categories with the same id as the update button which was pressed
				 mysqli_stmt_bind_param($stmt,'si',$the_drink_title, $drink_id );
				 mysqli_stmt_execute($stmt);
				 mysqli_stmt_close($stmt);//Close statment
				 mysqli_stmt_close($connection);//Close database
				 redirect("drink_categories.php");
			   }						 
			}
		 }
			?>

			</div>
			<div class = "form-group">
			<input class = "btn btn-primary" type = "submit" name = "update_category" value="Update Drink Category">
			</div>
			
		</form><!-- Update category POST data form end -->