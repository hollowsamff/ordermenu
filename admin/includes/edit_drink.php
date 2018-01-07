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
//Page used to edit the drink from the drink.php page

if(isset($_GET['p_id'])){
	
		$get_drink_id = escape($_GET['p_id']);//Put sent value in varable
	}	
	     //Find the drink with the same id that was sent from the drink.php page
		 $stmt = mysqli_prepare($connection,"SELECT drink_id, drink_name, drink_description, drink_category_id, drink_price, drink_image, drink_portions 
		 FROM drinks WHERE drink_id = ?");
		 mysqli_stmt_bind_param($stmt,"i", $get_drink_id);
		 $stmt->execute();
         $stmt->bind_result($drink_id, $drink_name, $drink_description, $drink_category_id, $drink_price, $drink_image, $drink_portions);
	
	
		//Show all the fields from the drink	database on the page
	   while($stmt->fetch()){
			//Varables = the the values from the database
			$drink_id = escape($drink_id) ;
	
			$drink_name = escape($drink_name);
			
			$drink_description = escape($drink_description);
			$drink_description =  stripslashes( $drink_description);
				
			$drink_category_id = escape($drink_category_id);
			
			$drink_image = escape($drink_image);
			
			$drink_price= escape($drink_price);
			$drink_price = number_format(floor($drink_price*100)/100,2, '.', '');
			
            $drink_portions = escape($drink_portions);	 
		
	    }

		
	?>	 
<?php

//Page is used to add a drink to database - is include for the drinks.php page
if(isset($_POST["edit_drink"])){ //Run when the page form is sent

 $drink_name =  escape($_POST["drink_name"]);
 $drink_category =  escape($_POST["drink_category"]);
 $drink_description = escape($_POST["drink_description"]);
 $drink_portions = escape($_POST["drink_portions"]);
 
 $drink_price = escape($_POST["drink_price"]); 
 $drink_price =   number_format(floor($drink_price*100)/100,2, '.', '');
 $drink_price  = floatval($drink_price);   
 
////////////////////////Data validation		  
	  
        //Associative arrays replace the index with a lable - this is called a key
		$error = ["drinkname" => "", "image" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array
					  		
	   //Used to test if the image is fake 
	   $drink_image_temp = $_FILES['image']['tmp_name'];
	   $drink_image = $_FILES['image']['name'];
	  
	   if (!empty($drink_image_temp)) {

			list($width, $height) = getimagesize($drink_image_temp);
			
			if ($width < 1 || $height <1 ){
				
				 $error['image'] = 'You can not upload fake images on this website.';
					 
			}else{//When the image is real
				
			   //Function used to save the image - move from temp location to websites image folder
			   
			   $drink_image = $_FILES['image']['name'];
			   move_uploaded_file ($drink_image_temp, "../images/$drink_image");

			}
		}

	   foreach ($error  as $key => $value) { // Used to test for and show error messages 
			
			if (empty($value)){
				
				unset($error[$key]);//Remove old values out of empty fields
			
		      }
		    }
			
		if(empty($error)){ //When no errors are found add drink
		
			   //Remove values from error messages
			   $drinkname ='';
			
			       if(empty($drink_image)){//If user does not change image keep current image
							
						$stmt2 = mysqli_prepare($connection,"SELECT drink_image FROM drinks WHERE drink_id = ?");
						mysqli_stmt_bind_param($stmt2,"i", $get_drink_id);
						mysqli_stmt_execute($stmt2);
						
						$stmt2->bind_result($drink_image);

						 while($stmt2->fetch()){//Loop though the database search and put the found image in a variable
							
						  $drink_image = $drink_image ;

					     }
					  mysqli_stmt_close($stmt2);//Close statment connection   
					}
					
//////////////////////////////////////Edit drink	
		       if(is_admin()){//Only logged in Admin users can edit code
		
				   $stmt = mysqli_prepare($connection, "UPDATE  drinks SET drink_name = ?, drink_description = ?, drink_portions = ?, drink_price = ?,
				   drink_category_id = ?, drink_image = ?
				   WHERE drink_id = ?");
				   
				   mysqli_stmt_bind_param($stmt,'ssidisi',$drink_name, $drink_description, $drink_portions, $drink_price, $drink_category, $drink_image, $get_drink_id);

				   mysqli_stmt_execute($stmt);
				   
				   if(!$stmt){ // die("Query error")."<br>". mysqli_error($stmt); 
				   }
					//Remove values so drinks can input another drink without reloding the page
				   $drink_name =  null;
				   $drink_description = null;
					 
			       mysqli_stmt_close($stmt);//Close statment connection
			   }
				redirect("drinks.php");
				
                echo " <h4> Drink Updated: " . " " . "<a href='drinks.php'>View drinks</a></h4>";

			  }

		}		 		


?>
<div class="container-fluid">

   <div class="col-lg-12">

   
   
	<h2> Edit Drink</h2>
	<form action = "" method="post" enctype="multipart/form-data"><!-- --> 

	<div class = "form-group">
	<label for= "title">Drink Name</label>
	<input type="text" name="drink_name" id="drink_name" class="form-control" placeholder="Enter drink name" autocomplete="on" value="<?php echo isset($drink_name) ? $drink_name : '' ;?>" >
	<h4 class="warning_red"><?php echo isset($error['drinkname']) ? $error['drinkname'] : '' ?></h4>
    </div>

	<style>#error_message_drink_name{color:red;display:none}</style>
	<h4 id="error_message_drink_name" class="error">drink name cannot be empty.</h4>
	
	<div class = "form-group">
	<label for= "title">Drink Description</label>
	<input type="text" name="drink_description" id="drink_description" class="form-control" placeholder="Enter drink description" autocomplete="on" value="<?php echo isset($drink_description) ? $drink_description : '' ;?>" >
    </div>
	
	<div class = "form-group">
	<label for= "title">Portions Sold</label>
	<input type="number_format" name="drink_portions" id="drink_portions" class="form-control" placeholder="Enter drink portions" autocomplete="on" value="<?php echo isset($drink_portions) ? $drink_portions : '' ;?>" >
    </div>
	
	<div class = "form-group">
	<label for= "title">Drink Price (inc VAT)</label>
	<input type="text" name="drink_price" id="drink_price" class="form-control" placeholder="Enter drink price" autocomplete="on" value="<?php echo isset($drink_price) ? $drink_price: '' ;?>" >
    </div>

	<div class = "form-group">
	<label for= "drinks_image">Drink Image</label>
	<input  type = "file" name = "image"  alt='drinkimage'>
	<h4 class="warning_red"><?php echo isset($error['image']) ? $error['image'] : '' ?></h4>
    </div>
	
	<div class = "form-group">
	<label for= "post_categories">Drink Category</label>

	<select name="drink_category" id="drink_category" class="form-control" >

	<?php
	
     //Show a list of all the meal_category from database meal_category table - current value
	 $stmt = mysqli_prepare($connection,"SELECT * FROM drink_category WHERE drink_category_id = {$drink_category_id}");
	 $stmt->bind_result($drink_id , $drink_title);
	 if($stmt->execute()){
		
	  //Bind these variable to the SQL results
	  $stmt->bind_result($drink_id , $drink_title);
	  
		while($stmt->fetch()){
	
		$drink_id = escape($drink_id );
		$drink_title = escape($drink_title);
		echo "<option value='$drink_id'>{$drink_title}</option>";

		}
	 }
	  mysqli_stmt_close($stmt);//Close statment connection 
	?>
	

	<?php	
     //Show a list of all the meal_category from database meal_category table - other options
	 $stmt = mysqli_prepare($connection,"SELECT * FROM drink_category WHERE drink_category_id != {$drink_category_id}");
	 $stmt->bind_result($drink_id , $drink_title);
	 if($stmt->execute()){
		
	  //Bind these variable to the SQL results
	  $stmt->bind_result($drink_id , $drink_title);
	  
		while($stmt->fetch()){
	
		$drink_id = escape($drink_id );
		$drink_title = escape($drink_title);
		echo "<option value='$drink_id'>{$drink_title}</option>";

		}
	 }
	  mysqli_stmt_close($stmt);//Close statment connection 
	?>
	</select>
	</div>

	<div class = "form-group">
    <input class = "btn btn-primary" type = "submit" name = "edit_drink" value="Edd Drink" id ="edit_drink">
	</div> 						
    </form>  
	
    </div>
 <!-- /.container-fluid -->
 </div>								