<script> 

$('document').ready(function(){
	
	var sendForm= true;
	
	//If the drinkname or description fields are blank the form  cannot  be submited
	$('#add_drink').click(function(){
	
		var str = $('#drink_name').val();
		if (str == ""){
			event.preventDefault();	
			//Show error message
			$('#error_message_drink_name').css('display','inline');
		}
		
		var str = $('#drink_description').val();
		if (str == ""){
			event.preventDefault();	
			//Show error message
			$('#error_message_description').css('display','inline');
		}
		
		
	});
	
});
 

</script>

<?php
//Page is used to add a drink to database - is include for the drinks.php page
if(isset($_POST["add_drink"])){ //Run when the page form is sent

   $drink_name =  escape($_POST["drink_name"]);
	 
   $drink_category =  escape($_POST["drink_category"]);

   $drink_description = escape($_POST["drink_description"]);
   $drink_portions = escape($_POST["drink_portions"]);
      	  
   $drink_price = escape($_POST["drink_price"]);
   $drink_price =   number_format(floor($drink_price*100)/100,2, '.', '');
   $drink_price  = floatval($drink_price);   
  			
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
			
			   $stmt = mysqli_prepare($connection, "INSERT INTO drinks(drink_name, drink_description, drink_price, drink_category_id, drink_image, drink_portions) 
			   VALUES (?, ? , ? ,?,?,? )" );
			   
			   mysqli_stmt_bind_param($stmt,'ssdisi',$drink_name, $drink_description, $drink_price, $drink_category, $drink_image,$drink_portions);

			   mysqli_stmt_execute($stmt);
			   
			   if(!$stmt){ // die("Query error")."<br>". mysqli_error($stmt); 
			   }
				//Remove values so drinks can input another drink without reloding the page
			   $drink_name =  null;
			   $drink_description = null;
		
			  		   
			   mysqli_stmt_close($stmt);//Close statment connection
			   
						   
               echo " <h4>Drink Created: " . " " . "<a href='drinks.php'>View drinks</a></h4>";

			  }

		}		 		


?>
<div class="container-fluid">

   <div class="col-lg-12">

	<h2> Add drink</h2>
	<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 
	
	
	<div class = "form-group">
	<label for= "title">Drink Name</label>
	<input type="text" name="drink_name" id="drink_name" class="form-control" placeholder="Enter drink name" autocomplete="on" value="<?php echo isset($drink_name) ? $drink_name : '' ;?>" >
	<h4 class="warning_red"><?php echo isset($error['drinkname']) ? $error['drinkname'] : '' ?></h4>
    </div>

	<style>#error_message_drink_name{color:red;display:none}</style>
	<h4 id="error_message_drink_name" class="error">Drink name cannot be empty.</h4>
	
	
	<div class = "form-group">
	<label for= "title">Drink Description</label>
	<input type="text" name="drink_description" id="drink_description" class="form-control" placeholder="Enter drink description" autocomplete="on" value="<?php echo isset($drink_description) ? $drink_description : '' ;?>" >
    </div>
	
	<div class = "form-group">
	<label for= "title">Portions Sold</label>
	<input type="number_format" name="drink_portions" id="drink_portions" class="form-control" placeholder="Enter meal portions" autocomplete="on" value="<?php echo isset($drink_portions) ? $drink_portions : '' ;?>" >
    </div>
	
    <style>#error_message_description{color:red;display:none}</style>
	<h4 id="error_message_description" class="error">Description cannot be empty.
	</h4>
	
	<div class = "form-group">
	<label for= "title">Drink Price (inc VAT)</label>
	<input type="number_format" name="drink_price" id="drink_price" class="form-control" placeholder="Enter Drink Price" autocomplete="on" value="<?php echo isset($drink_price) ? $drink_price : '' ;?>" >
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
		
		 //Show a list of all the drink_category from database drink_category table
		 $stmt = mysqli_prepare($connection,"SELECT drink_category_id, drink_category_name FROM drink_category");
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
    <input class = "btn btn-primary" type = "submit" name = "add_drink" value="Add Drink" id ="add_drink">
	</div> 						
    </form>  
	
    </div>
 <!-- /.container-fluid -->
 </div>								