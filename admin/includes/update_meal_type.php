        <!-- Update meal type POST data form-->
		<form action= "" method = "post">
			<div class = "form-group">
			<label for="cat_title">Update Meal Type</label>
			
				<?php
					   //Used to show text box which is used to edit the categories from database categories table - activate when edit button is pressed
					   if(isset($_GET['edit2'])){
						   
							$cat_id = escape($_GET['edit2']);//Value send from the Edit button
						   
						     //Find all the categories from database categories table where the cat_id is equal to the send value
						     $stmt = mysqli_prepare($connection,"SELECT meal_type_id, meal_type_name , meal_type_cost FROM  meal_type WHERE meal_type_id = ?");
							 mysqli_stmt_bind_param($stmt,'i', $cat_id );
							 mysqli_stmt_execute($stmt);
							 $stmt->bind_result($cat_id , $cat_title ,$cat_price );

							//Show all the categories from database categories table 
							 while($stmt->fetch()){
								 
								$cat_id = $cat_id;
								$cat_title = $cat_title;
								$cat_price = $cat_price;
							    $cat_price =   number_format(floor($cat_price*100)/100,2, '.', '');
			
			   ?>
			
			<input value ="<?php if(isset($cat_title)){echo $cat_title;}?>"type = "text" class = "form-control"  name = "cat_title">
			<br>
			<input value ="<?php if(isset($cat_price)){echo $cat_price;}?>"type = "number_format" class = "form-control"  name = "cat_price">
   <?php } }
				  mysqli_stmt_close($stmt);//Close statment
				
   ?>
   
		 <?php
		 
			//Code runs after the Current Categories table update button is pressed and the Update category show edit box code runs
			//Update query update_category POST is sent from Update category POST data form
			if(isset($_POST['update_category'])){//If user has sent a value useing the Update category form run the code
			 
             $the_cat_title = $_POST['cat_title'];
			 $the_cat_price = $_POST['cat_price'];
			 $the_cat_price  = floatval($the_cat_price);
		
	          	if($the_cat_title == "" || empty($the_cat_title)){//Test if the value is blank
			  
				echo"<h4 class='warning_red'>Meal Type shoud not be empty!</h4>";
				
			}else{//Insert value into database categories table
				
			//Keep same value if user makes no changes
			//Use function to test if the category exists
	
			if ($the_cat_title != $cat_title  and  meal_type_exists($the_cat_title) !== false){
				
				echo"<h4 class='warning_red'>Meal Type already exists!</h4>";

			}else{

				 $stmt = mysqli_prepare($connection,"UPDATE meal_type 
				 SET meal_type_name = ?, meal_type_cost = ? WHERE meal_type_id  = ?");
				 //Update the categories with the same id as the update button which was pressed
				 mysqli_stmt_bind_param($stmt,'sdi',$the_cat_title, $the_cat_price, $cat_id );
				 mysqli_stmt_execute($stmt);
				 mysqli_stmt_close($stmt);//Close statment
				 redirect("meal_categories.php");
			   }						 
			}
		 }
			?>

			</div>
			<div class = "form-group">
			<input class = "btn btn-primary" type = "submit" name = "update_category" value="Update  Meal Type">
			</div>
			
		</form><!-- Update category POST data form end -->