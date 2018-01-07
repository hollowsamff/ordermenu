<script> 

$('document').ready(function(){
	
//Used to show the tool tip on the meal allergy boxes - explains that the old allergies will be deleted if the user selects a new allegy	
$('[data-toggle="tooltip"]').tooltip(); 
	
});
	var sendForm= true;
	
	//If the mealname, password , email fields are blank the meal can not submit the form
	$('#edit_meal').click(function(){
	
		var str = $('#meal_name').val();
		if (str == ""){
			event.preventDefault();	
			//Show error message
			$('#error_message_meal_name').css('display','inline');
		}
		
		
	});
	
});
 
</script>



<?php
//Page used to edit the meal from the meal.php page

if(isset($_GET['p_id'])){
	
		$get_meal_id = escape($_GET['p_id']);//Put sent value in varable
	}	
	     //Find the meal with the same id that was sent from the meal.php page
		 $stmt = mysqli_prepare($connection,"SELECT meal_id, meal_name, meal_description, meal_type_id, meal_portions, category_id, meal_image 
		 FROM meal WHERE meal_id = ?");
		 mysqli_stmt_bind_param($stmt,"i", $get_meal_id);
		 $stmt->execute();
         $stmt->bind_result($meal_id, $meal_name, $meal_description, $meal_type_id,  $meal_portions, $category_id,$meal_image);
	
	
		//Show all the fields from the meal	database on the page
	   while($stmt->fetch()){
			//Varables = the the values from the database
			$meal_id = escape($meal_id) ;
	
			$meal_name = escape($meal_name);
			
			$meal_description = escape($meal_description);
			$meal_description =  stripslashes( $meal_description);
			
				
			$meal_type_id = escape($meal_type_id);
			
			$meal_image = escape($meal_image);
			
			$meal_portions= escape($meal_portions);
			
			$category_id= escape($category_id);		
	    }

		
	?>	 
<?php

//Page is used to add a meal to database - is include for the meals.php page
if(isset($_POST["edit_meal"])){ //Run when the page form is sent

       $meal_name =  escape($_POST["meal_name"]);
	   $meal_category =  escape($_POST["meal_category"]);
	   $meal_type =  escape($_POST["meal_type"]);
	   $meal_description = escape($_POST["meal_description"]);
	   $meal_portions = escape($_POST["meal_portions"]);  
	   
////////////////////////Data validation		  
	  
        //Associative arrays replace the index with a lable - this is called a key
		$error = ["mealname" => "", "image" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array
					  		
	   //Used to test if the image is fake 
	   $meal_image_temp = $_FILES['image']['tmp_name'];
	   $meal_image = $_FILES['image']['name'];
	  
	   if (!empty($meal_image_temp)) {

			list($width, $height) = getimagesize($meal_image_temp);
			
			if ($width < 1 || $height <1 ){
				
				 $error['image'] = 'You can not upload fake images on this website.';
					 
			}else{//When the image is real
				
			   //Function used to save the image - move from temp location to websites image folder
			   
			   $meal_image = $_FILES['image']['name'];
			   move_uploaded_file ($meal_image_temp, "../images/$meal_image");

			}
		}

	   foreach ($error  as $key => $value) { // Used to test for and show error messages 
			
			if (empty($value)){
				
				unset($error[$key]);//Remove old values out of empty fields
			
		      }
		    }
			
		if(empty($error)){ //When no errors are found add meal
		
			   //Remove values from error messages
			   $mealname ='';
			
			       if(empty($meal_image)){//If user does not change image keep current image
							
						$stmt2 = mysqli_prepare($connection,"SELECT meal_image FROM meal WHERE meal_id = ?");
						mysqli_stmt_bind_param($stmt2,"i", $get_meal_id);
						mysqli_stmt_execute($stmt2);
						
						$stmt2->bind_result($meal_image);

						 while($stmt2->fetch()){//Loop though the database search and put the found image in a variable
							
						  $meal_image = $meal_image ;

					     }
					  mysqli_stmt_close($stmt2);//Close statment connection   
					}
					
//////////////////////////////////////Edit meal	
		 
			   $stmt = mysqli_prepare($connection, "UPDATE  meal SET meal_name = ?, meal_description = ?, meal_type_id = ?, meal_portions = ?, category_id = ?, meal_image = ?
			   WHERE meal_id = ?");
			   
			   mysqli_stmt_bind_param($stmt,'ssiiisi',$meal_name, $meal_description, $meal_type, $meal_portions, $meal_category, $meal_image ,$get_meal_id);

			   mysqli_stmt_execute($stmt);
			   
			   if(!$stmt){ // die("Query error")."<br>". mysqli_error($stmt); 
			   }
				//Remove values so meals can input another meal without reloding the page
			   $meal_name =  null;
			   $meal_description = null;
		       
			  
			   mysqli_stmt_close($stmt);//Close statment connection
			   
//////////////////////////Add  meal allergies 
  
			    //Store values from the allergy multi select
				if (isset($_POST['ary'])){
					
					//Remove old allergys
					$stmt = mysqli_prepare($connection, "DELETE FROM allergy_meal  WHERE meal_id  = ? ");
				    mysqli_stmt_bind_param($stmt,'i',$meal_id);
				    mysqli_stmt_execute($stmt);
				    mysqli_stmt_close($stmt);//Close statment connection 

					$values = $_POST['ary'];
					foreach ($values as $a){//$a is the id of the allergy
					
					    //Input the select allergys into the meal_allergy composite table
						$stmt = mysqli_prepare($connection, "INSERT INTO allergy_meal(alergy_id,meal_id) 
			            VALUES (?,?)" );
						
						 mysqli_stmt_bind_param($stmt,'ii',$a ,$meal_id );

			             mysqli_stmt_execute($stmt);
	
					 }

				}//End input allergy loop	
				
				redirect("meals.php");
				
               //echo " <h4> Meal Created: " . " " . "<a href='meals.php'>View meals</a></h4>";

			  }

		}		 		


?>
<div class="container-fluid">

   <div class="col-lg-12">
   
	<h2> Edit Meal</h2>
	<form action = "" method="post" enctype="multipart/form-data"><!-- --> 

	<div class = "form-group">
	<label for= "title">Meal Name</label>
	<input type="text" name="meal_name" id="meal_name" class="form-control" placeholder="Enter meal name" autocomplete="on" value="<?php echo isset($meal_name) ? $meal_name : '' ;?>" >
	<h4 class="warning_red"><?php echo isset($error['mealname']) ? $error['mealname'] : '' ?></h4>
    </div>

	<style>#error_message_meal_name{color:red;display:none}</style>
	<h4 id="error_message_meal_name" class="error">Meal name cannot be empty.</h4>
	
	<div class = "form-group">
	<label for= "title">Meal Description</label>
	<input type="text" name="meal_description" id="meal_description" class="form-control" placeholder="Enter meal description" autocomplete="on" value="<?php echo isset($meal_description) ? $meal_description : '' ;?>" >
    </div>
	
	<div class = "form-group">
	<label for= "title">Portions Sold</label>
	<input type="number_format" name="meal_portions" id="meal_portions" class="form-control" placeholder="Enter meal portions" autocomplete="on" value="<?php echo isset($meal_portions) ? $meal_portions : '' ;?>" >
    </div>

	<div class = "form-group">
	<label for= "meals_image">Meal Image</label>
	<input  type = "file" name = "image"  alt='mealimage'>
	<h4 class="warning_red"><?php echo isset($error['image']) ? $error['image'] : '' ?></h4>
    </div>
	
	
		<div class = "form-group">
		<label for= "post_categories">Meal Type</label>
		<select name="meal_type" id="meal_type" class="form-control" >
		<?php		
		 //Show a list of all the meal types from database meal_type table - current value
		 $stmt = mysqli_prepare($connection,"SELECT * FROM meal_type  WHERE meal_type_id = {$meal_type_id}");
		 $stmt->bind_result($cat_id , $cat_title,$cat_price);	
		 if($stmt->execute()){
			
		  //Bind these variable to the SQL results
		  $stmt->bind_result($cat_id , $cat_title, $cat_price);
		 
			while($stmt->fetch()){
		
			$cat_id = escape($cat_id );
			$cat_title = escape($cat_title);
			
			echo "<option value='$cat_id'>{$cat_title}</option>";

			}
		 }
		  mysqli_stmt_close($stmt);//Close statment connection 
		?>
		 <?php		
		 //Show a list of all the meal types from database meal_type table - other options
		 $stmt = mysqli_prepare($connection,"SELECT * FROM meal_type WHERE meal_type_id != {$meal_type_id}");
		 $stmt->bind_result($cat_id , $cat_title);	
		 if($stmt->execute()){
			
		  //Bind these variable to the SQL results
		  		 $stmt->bind_result($cat_id , $cat_title,$cat_price);	
		 
			while($stmt->fetch()){
		
			$cat_id = escape($cat_id );
			$cat_title = escape($cat_title);
			echo "<option value='$cat_id'>{$cat_title}</option>";

			}
		 }
		  mysqli_stmt_close($stmt);//Close statment connection 
		?>
		</select>
		</div>

	
		<div class = "form-group">
		<label for= "post_categories">Meal Category</label>
	
		<select name="meal_category" id="meal_category" class="form-control" >
		 <?php	
		 //Show a list of all the meal_category from database meal_category table - current value
		 $stmt = mysqli_prepare($connection,"SELECT * FROM meal_category WHERE meal_category_id = {$category_id}");
		 $stmt->bind_result($cat_id , $cat_title);
		 if($stmt->execute()){
			
		  //Bind these variable to the SQL results
		  $stmt->bind_result($cat_id , $cat_title);
		  
			while($stmt->fetch()){
		
			$cat_id = escape($cat_id );
			$cat_title = escape($cat_title);
			echo "<option value='$cat_id'>{$cat_title}</option>";

			}
		 }
		  mysqli_stmt_close($stmt);//Close statment connection 
		?>
		<?php	
		 //Show a list of all the meal_category from database meal_category table - other options
		 $stmt = mysqli_prepare($connection,"SELECT * FROM meal_category WHERE meal_category_id != {$category_id}");
		 $stmt->bind_result($cat_id , $cat_title);
		 if($stmt->execute()){
			
		  //Bind these variable to the SQL results
		  $stmt->bind_result($cat_id , $cat_title);
		  
			while($stmt->fetch()){
		
			$cat_id = escape($cat_id );
			$cat_title = escape($cat_title);
			echo "<option value='$cat_id'>{$cat_title}</option>";

			}
		 }
		  mysqli_stmt_close($stmt);//Close statment connection 
		?>
		</select>
		</div>
		 <div class = "form-group">
		 
		<label for= "post_categories" href="#" data-toggle="tooltip" title="Old allergies will be deleted if you selects a new allegy">Meal Allergies - </label>
		
		<!--Show the allegys of the meal-->
		<label for= "post_categories" href="#" data-toggle="tooltip" title="Old allergies will be deleted if you selects a new allegy" >current allergys - </label>	
		<td>	
		<?php
		   //Query to find the allergys of the post 
			$query ="SELECT 
			allergy_meal.alergy_id,
			allergy_meal.meal_id,
			allergy_meal.allergy_meal_id,
					
			allergy.allergry_id,
			allergy.allergy_name

			FROM allergy_meal		
			INNER JOIN allergy
			
			ON allergy_meal.alergy_id = allergy.allergry_id WHERE allergy_meal.meal_id =".$meal_id." ORDER BY allergy.allergy_name ASC";
					
			$select_posts = mysqli_query($connection,$query);			   
			  while($row = mysqli_fetch_assoc($select_posts)){

			  $allergy_meal_id  = escape($row['allergry_id']);
			  echo $allergy_meal_name = escape($row['allergy_name']). " " ;
			
			}  


		?>	
		</td>
		
		<select name="ary[]" multiple="multiple" class="form-control">
	
		<?php

		 //Show a list of all the allergys from database allergy table
		 $stmt = mysqli_prepare($connection,"SELECT DISTINCT allergry_id, allergy_name, allergy_description  FROM allergy  ORDER BY allergy_name ASC");

		 echo "<option value='$allergry_id'>{$allergry_title}</option>";
		 
		 if($stmt->execute()){
			 				
		  //Bind these variable to the SQL results
		  $stmt->bind_result($allergry_id , $allergry_title, $allergy_description );
		  
			while($stmt->fetch()){
		
			echo "<option value='$allergry_id'>{$allergry_title}</option>";

			}
		 }
		  mysqli_stmt_close($stmt);//Close statment connection 
		  
 
		?>
		</select>
		</div>


	<div class = "form-group">
    <input class = "btn btn-primary" type = "submit" name = "edit_meal" value="Edit Meal" id ="edit_meal">
	</div> 						
    </form>  
	
    </div>
 <!-- /.container-fluid -->
 </div>								