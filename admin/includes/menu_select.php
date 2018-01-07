
<!---
Used to show the menu - user can edit the menu items
-->

<?php //Code is used to change multiple meals status and delete multiple meals 
	include("delete_modal.php");
?>
<div class="container-fluid">

   <div class="col-lg-12">

	<h2>Food Menu </h2>
					
	<h4>Input the number of items you want to to apear on the menu</h4>
	<h5>You cannot input duplicate meals into the menu</h5>
	
		
	<?php //Show messages - the type SESSION stores what type of message it is -
	//Differnt warnings will apear depending on the type is set: for example a success class will be used if a a meal is updated
	if (!empty($_SESSION['message'])){
			
	dispay_message($_SESSION['type']);

	}	
	?>
		
	<?php $number_in_menu = 12;

    $_SESSION['menuitem'] = $number_in_menu;//Used to to the number in menu when show menu page loads
			
	if (isset($_POST['show_value'])){

		if 	(  ($_POST['num_in_menu'] > 0) and ($_POST['num_in_menu'] < 13) ){ //The number has to be between 1 and twelve
			
			 $number_in_menu = escape($_POST['num_in_menu']);
			 $_SESSION['menuitem'] = $number_in_menu;//Used to show the number of items menu when show menu page loads
		
			}else{			
					//Type of message
	                $_SESSION['type'] = "alert alert-danger";
					//Message content
				    set_message("The number has to be between 1 and twelve");					
			}
			
	}
	
	?>
	
	<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 
	
	<input type = "number"  id ="num_in_menu"  name="num_in_menu"  class = "form-group">
	
	<div class = "form-group">
	
	<input class = "btn btn-primary" type = "submit" name = "show_value" value="Submit" id ="add_meal" placeholder="Select number of items in menu">
	 
	</div>
	</form>
     
<!--Edit menu image -->	 
	<form action = "menu.php?test=6"  multiple="multiple" method="post" enctype="multipart/form-data">
	
	<div class = "form-group">
	
	    <input class = "btn btn-primary" type = "submit" name = "edit_menu_image" value="Edit Meal Image" id ="edit_menu_image">
		<a class ="btn btn-primary" href ="show_menu.php" >Show Menu</a>
	 
	</div>
	</form>

	<?php
	//Used to edit menu image
    if(isset($_POST["edit_menu_image"])){ //Run when the form is sent

			//Id of updating menu image
			$add_meal_id = 6;			
	?>	
			<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 	
			<div class = "form-group">
		
			<?php
	
			 //Show a list of all the meal_category from database meal_category table after the user selects an option from the drop down menu
			 $stmt = mysqli_prepare($connection,"SELECT food_menu_image, food_menu_id FROM food_menu 
			 WHERE food_menu_id =  ? ");
			 mysqli_stmt_bind_param($stmt, "i" , $add_meal_id);
		
			 if($stmt->execute()){
				
				//Bind these variable to the SQL results
				$stmt->bind_result($menu_image, $menu_id);
				  
				while($stmt->fetch()){
			
				}			
				
			 }
			  mysqli_stmt_close($stmt);//Close statment connection 
		
			?>
		
			</div>
			<img width='100'  src ='../images/<?php echo $menu_image?>' alt='menuimage'>
			
			<input type="text" name="meal_description" id="meal_description" class="form-control" 
			autocomplete="on" value="<?php echo isset($menu_image) ? $menu_image  : '' ;?>" >
			  
			<div class = "form-group">
		
			<label for= "meals_image">Select Menu Image</label>
			<input  type = "file" name = "image"  alt='mealimage'>
			</div>	   
			<input class = "btn btn-primary" type = "submit" name = "update_menu_image" value="Update Image" id ="update_menu_image">	
			
			 <br> <br>
			</div> 						
			</form>  
			
		<?php					
	}	
	
	if(isset($_POST["update_menu_image"])){ //Run when the page form is sent
	
	  $meal_image_temp = $_FILES['image']['tmp_name'];
	  $meal_image = $_FILES['image']['name'];
      $old_image = $_POST['meal_description'];
  
	  //Used to test if the image is fake 
	  if (!empty($meal_image_temp)) {

			list($width, $height) = getimagesize($meal_image_temp);
			
			if ($width < 1 || $height <1 ){
				
				//Type of message
				$_SESSION['type'] = "alert alert-danger";
				//Message content
				set_message("You can not upload fake images on this website.");
				$meal_image = "";
                redirect("menu.php");
				return;
					 
			}else{//When the image is real
				
			   //Function used to save the image - move from temp location to websites image folder	   
			   $meal_image = $_FILES['image']['name'];
			   move_uploaded_file ($meal_image_temp, "../images/$meal_image");

			}
		} 
		
	   $add_meal_id = 6;//Id of menu image being updated
			 
	   if(empty($meal_image)){//If user does not change image keep current image
          
                 $meal_image = $old_image;
	    }
 
		 $stmt = mysqli_prepare($connection, "UPDATE food_menu SET food_menu_image = ?
		 WHERE food_menu_id = ?");
		 
		 mysqli_stmt_bind_param($stmt,'si',$meal_image , $add_meal_id);
         mysqli_stmt_execute($stmt);

		 mysqli_stmt_close($stmt);//Close statment connection	
			   
			   	//Type of message
				$_SESSION['type'] = "alert alert-success";
				//Message content
				set_message("Menu Image Updated");
			    redirect("menu.php");
	      }	
		
	?>
<!--Edit menu image  code end-->		
	
	<table class ="table table-bordered table-hover">
		<thead style="background-color:white;">
			<tr>
				<td></td>			
				<td>Meal Name</td>			
				<td>Edit Menu Item</td>
			</tr>
		</thead>

		<tbody style="background-color:white;">
	
	<?php 
	   
	   //Show meal items in menu  
	   $query ="SELECT 
		meal.meal_id,
		meal.meal_name,
		meal.meal_description,
		meal.meal_type_id,
		meal.meal_portions,
		meal.category_id,
		meal.meal_image,

		food_menu.food_menu_id,
		food_menu.meal_id,
        food_menu.food_menu_image
		
		FROM meal
									
		INNER JOIN food_menu
		ON meal.meal_id = food_menu.meal_id LIMIT {$number_in_menu}";

		$select_posts = mysqli_query($connection,$query);
	     
	    $count = 1 ;
		//Show all the fields from the meals table 
		while($row = mysqli_fetch_assoc($select_posts)){
		
	    $meal_id = escape($row['meal_id']);
	    $meal_ids [] = $meal_id ;//Used to test if updated menu items are duplicates
		
		$food = escape($row['food_menu_image']);
		
	    $meal_name = escape($row['meal_name']);	
	
		$food_menu_id = escape($row['food_menu_id']);
	
		//Id of the menu item 
		echo "<td>".$count."</td>";
		echo "<td>".$meal_name."</td>";
		
	    echo "<td><a class='btn btn-info' href='menu.php?meal_id={$food_menu_id}'>Edit Menu Item</a></td>";//Use id of menu item to edit it
		
		$count ++;
		echo"</tr>";
		}
	?>
	
	</tbody>
	</table>
	</form>	
	<br>


	<?php
	//Used to edit menu image
    if(isset($_GET["item_id"])){ //Run when the form is sent

		$test = escape($_GET['item_id'])	
				
	?>	
			<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 	
			<div class = "form-group">
		
			<?php
	
			 //Show a list of all the meal_category from database meal_category table after the user selects an option from the drop down menu
			  $stmt = mysqli_prepare($connection,"SELECT  meal_id , meal_name FROM meal WHERE meal_id =  ? ");
			 mysqli_stmt_bind_param($stmt, "i" , $test);
		
			 if($stmt->execute()){
				
				//Bind these variable to the SQL results
				$stmt->bind_result($menu_image, $menu_id);
				  
				while($stmt->fetch()){
		
				}			
				
			 }
			  mysqli_stmt_close($stmt);//Close statment connection 
		
			?>
		
			</div>
			
			<input type="text" name="meal_name" id="meal_name" class="form-control" 
			autocomplete="on" value="<?php echo isset($menu_id) ? $menu_id  : '' ;?>" >
			<br>
            <input type="number" name="meal_quantity" id="meal_quantity" class="form-control" value="" placeholder="Item quantity" >

            <br>
			<input class = "btn btn-primary" type = "submit" name = "update_menu_image" value="Update Image" id ="update_menu_image" >	
			
			 <br><br>
			</div> 						
			</form>  
			
		<?php					
	}		
	

	//Used to filter the meal by meal category - send from edit menu button
	if(isset($_GET['meal_id'])){
		
		//Id of updating menu item	
	    $add_meal_id = escape($_GET['meal_id']);
		 
		?>
		
		<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 
		
		<div class = "form-group">
		<label for= "post_categories">Select Meal Category</label>
		<select name="meal_category" id="meal_category" class="form-control" >
		<?php
		
		 //Show a list of all the meal_category from database meal_category table after the user selects an option from the drop down menu
		 $stmt = mysqli_prepare($connection,"SELECT * FROM meal_category");
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
		<input class = "btn btn-primary" type = "submit" name = "add_meal" value="Find meal" id ="add_meal">
		</div> 						
		</form>  
		<?php
		?>	
		<!--Scroll to bottom of page when button is clicked-->		
		<script>

		$(document).ready(function(){

		window.scroll(0,1000);

		});

		</script>
		<?php
				
	}
	
	 //Page is used to edita meal  fromthe menu - is include for the meals.php page
	if(isset($_POST["add_meal"])){ //Run when the page form is sent

	//Show a list all the meal of the selected category
	//Id of selected category
    $selected_category = escape($_POST['meal_category']);

	include("select_meals.php");	
	
	}
	
	if(isset($_GET["selected_item_id"])){ //Run when the page form is sent

		    //Id of updating menu item and selected menu idem	
		    $add_meal_id = escape($_GET['meal_id']);     
		    $selected_item_id = escape($_GET['selected_item_id']);
	
			if(is_admin()){//Only logged in Admin users can edit code
																								 		 
				//Test if the added menu item is already in the menu - stops duplicate values being added - first value is tested value , secound is array
				//if (!in_array($add_meal_id, $meal_ids )) {
				if (false !== $key3 = array_search($add_meal_id, $meal_ids)) {
				   
				$mealids = $key3 + 1; 
				
                //Type of message
				$_SESSION['type'] = "alert alert-danger";
				//Message content
				set_message("Meal exists in menu item ". $mealids);

				redirect("menu.php");	
						
				}else{//Update menu item
				  if(is_admin()){
					//Type of message
	                $_SESSION['type'] = "alert alert-success";
					//Message content
				    set_message("Menu item updated");
						
					//Query used to update the selected menu item
					$stmt = mysqli_prepare($connection, "UPDATE food_menu SET meal_id = ? WHERE food_menu_id = ? ");
					mysqli_stmt_bind_param($stmt, 'ii', $add_meal_id, $selected_item_id);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);//Close statment connection
					redirect("menu.php");		
				  }		
				}

              }			
	}
		
    ?>
 </div>
 <!-- /.container-fluid -->
 </div>	

<?Php

//Used to delete a meal / meal allergy
//Delete post function
if(isset($_GET['delete']) && !empty($_SESSION)){//If user has sent the delete parameter useing the delete buttons

	if(is_admin()){//Only logged in Admin users can edit code
																					 
		echo $the_meal_id = escape($_GET['delete']);

		//Delete meal and meal_allergy
		$stmt = mysqli_prepare($connection, "DELETE FROM allergy_meal  WHERE meal_id  = ? ");
		mysqli_stmt_bind_param($stmt,'i',$the_meal_id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);//Close statment connection 
		
		$stmt = mysqli_prepare($connection, "DELETE FROM meal WHERE meal_id  = ? ");
		mysqli_stmt_bind_param($stmt,'i',$the_meal_id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);//Close statment connection 
			
		redirect("menu.php");//Refresh the page - the page needs to be refreshed for the delete to work   
	}
}

?>