<script> 

$('document').ready(function(){
	
	var sendForm= true;
	
	//If the mealname or description fields are blank the form  cannot  be submited
	$('#add_meal').click(function(){
	
		var str = $('#meal_name').val();
		if (str == ""){
			event.preventDefault();	
			//Show error message
			$('#error_message_meal_name').css('display','inline');
		}
		
		var str = $('#meal_description').val();
		if (str == ""){
			event.preventDefault();	
			//Show error message
			$('#error_message_description').css('display','inline');
		}
		
		
	});
	
});
 

</script>

<?php
//Page is used to add a meal to database - is include for the meals.php page
if(isset($_POST["add_meal"])){ //Run when the page form is sent

     $meal_name =  escape($_POST["meal_name"]);
	 $meal_category =  escape($_POST["meal_category"]);  echo "<br>";
	 $meal_type =  escape($_POST["meal_type"]);  echo "<br>";
	 $meal_description = escape($_POST["meal_description"]);  echo "<br>";
	 $meal_portions = escape($_POST["meal_portions"]);    echo "<br>";
  		  
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
			
			   $stmt = mysqli_prepare($connection, "INSERT INTO meal(meal_name, meal_description, meal_type_id, meal_portions, category_id, meal_image) 
			   VALUES (?, ? , ? ,?,?,? )" );
			   
			   mysqli_stmt_bind_param($stmt,'ssiiis',$meal_name, $meal_description, $meal_type, $meal_portions, $meal_category, $meal_image);

			   mysqli_stmt_execute($stmt);
			   
			   if(!$stmt){ // die("Query error")."<br>". mysqli_error($stmt); 
			   }
				//Remove values so meals can input another meal without reloding the page
			   $meal_name =  null;
			   $meal_description = null;
			   $meal_image = null;
			   $meal_portions = null;
	   
			   mysqli_stmt_close($stmt);//Close statment connection
			   
			    ////Insert one or more alergys   
			    $last_id = mysqli_insert_id($connection);//Id of the input last meal

			    //Store values from the allergy multi select
				if (isset($_POST['ary'])){
					
					$values = $_POST['ary'];
					foreach ($values as $a){//$a is the id of the allergy
					    //Input the select allergys into the meal_allergy composite table
						$stmt = mysqli_prepare($connection, "INSERT INTO allergy_meal(alergy_id, meal_id) 
			            VALUES (?,?)" );
						
						 mysqli_stmt_bind_param($stmt,'ii',$a ,$last_id );

			             mysqli_stmt_execute($stmt);
						
				    		$a;
					 }

				}	   
						
			   
               echo " <h4> Meal Created: " . " " . "<a href='meals.php'>View meals</a></h4>";

			  }

		}		 		


?>
<div class="container-fluid">

   <div class="col-lg-12">

	<h2> Add Meal</h2>
	<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 
	
	
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
	
    <style>#error_message_description{color:red;display:none}</style>
	<h4 id="error_message_description" class="error">Description cannot be empty.</h4>
	
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
		
		 //Show a list of all the meal types from database meal_type table
		 $stmt = mysqli_prepare($connection,"SELECT *  FROM meal_type");
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
		
		 //Show a list of all the meal_category from database meal_category table
		 $stmt = mysqli_prepare($connection,"SELECT *  FROM meal_category");
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
		<label for= "post_categories">Meal Allergies</label>
		<select name="ary[]" multiple="multiple" class="form-control">
	
		<?php

		 //Show a list of all the allergys from database allergy table
		 $stmt = mysqli_prepare($connection,"SELECT DISTINCT allergry_id, allergy_name, allergy_description FROM allergy  ORDER BY allergy_name ASC");

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
    <input class = "btn btn-primary" type = "submit" name = "add_meal" value="Add meal" id ="add_meal">
	</div> 						
    </form>  
	
    </div>
 <!-- /.container-fluid -->
 </div>								