<!---
Used to show the drink menu - user can edit the menu items
-->

<?php //Code is used to change multiple drinks status and delete multiple drinks 
	include("delete_modal.php");
?>
<div class="container-fluid">

   <div class="col-lg-12">

	<h2>Drink Menu </h2>
					
	<h4>Input the number of items you want to to apear on the menu</h4>
	<h5>You cannot input duplicate drinks into the menu</h5>
		
		
	<?php //Show messages - the type SESSION stores what type of message it is -
	//Differnt warnings will apear depending on the type is set: for example a success class will be used if a a drink is updated
	if (!empty($_SESSION['message'])){
			
	dispay_message($_SESSION['type']);

	}	
	?>
		
	<?php $number_in_drink_menu = 10;

    $_SESSION['foodmenuitem'] = $number_in_drink_menu;//Used to to the number in menu when show menu page loads
			
	if (isset($_POST['show_value'])){

		if 	(  ($_POST['num_in_menu'] > 0) and ($_POST['num_in_menu'] < 11) ){ //The number has to be between 1 and ten
			
			 $number_in_drink_menu = escape($_POST['num_in_menu']);
			 $_SESSION['foodmenuitem'] = $number_in_drink_menu;//Used to show the number of items menu when show menu page loads
		
			}else{			
					//Type of message
	                $_SESSION['type'] = "alert alert-danger";
					//Message content
				    set_message("The number has to be between 1 and ten");					
			}
			
	}
	
	?>
	
	<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 
	
	<input type = "number"  id ="num_in_menu"  name="num_in_menu"  class = "form-group">
	
	<div class = "form-group">
	
	<input class = "btn btn-primary" type = "submit" name = "show_value" value="Submit" id ="add_drink" placeholder="Select number of items in menu">
	 
	</div>
	</form>
     
<!--Edit menu image -->	 
	<form action = "drink_menu.php?test=1"  multiple="multiple" method="post" enctype="multipart/form-data">
	
	<div class = "form-group">
	
	    <input class = "btn btn-primary" type = "submit" name = "edit_menu_image" value="Edit Drink Image" id ="edit_menu_image">
		<a class ="btn btn-primary" href ="show_drinks_menu.php" >Show Menu</a>
	 
	</div>
	</form>

	<?php
	//Used to edit menu image
    if(isset($_POST["edit_menu_image"])){ //Run when the form is sent

			//Id of updating menu image
			$add_drink_id = 1;			
	?>	
			<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 	
			<div class = "form-group">
		
			<?php
	
			 //Show a list of all the drink_category from database drink_category table after the user selects an option from the drop down menu
			 $stmt = mysqli_prepare($connection,"SELECT drink_menu_image, drink_menu_id FROM drink_menu 
			 WHERE drink_menu_id =  ? ");
			 mysqli_stmt_bind_param($stmt, "i" , $add_drink_id);
		
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
			  
			<input type="text" name="drink_description" id="drink_description" class="form-control" 
			autocomplete="on" value="<?php echo isset($menu_image) ? $menu_image  : '' ;?>" >
			  
			
			<div class = "form-group">
			<label for= "drinks_image">Select Menu Image</label>
			<input  type = "file" name = "image"  alt='drinkimage'>
			</div>	   
			<input class = "btn btn-primary" type = "submit" name = "update_menu_image" value="Update Image" id ="update_menu_image">	
			
			 <br> <br>
			</div> 						
			</form>  
			
		<?php					
	}	
	
	if(isset($_POST["update_menu_image"])){ //Run when the page form is sent
	
	  $drink_image_temp = $_FILES['image']['tmp_name'];
	  $drink_image = $_FILES['image']['name'];
      $old_image = $_POST['drink_description'];
  
	  //Used to test if the image is fake 
	  if (!empty($drink_image_temp)) {

			list($width, $height) = getimagesize($drink_image_temp);
			
			if ($width < 1 || $height <1 ){
				
				//Type of message
				$_SESSION['type'] = "alert alert-danger";
				//Message content
				set_message("You can not upload fake images on this website.");
				$drink_image = "";
                redirect("drink_menu.php");
				return;
					 
			}else{//When the image is real
				
			   //Function used to save the image - move from temp location to websites image folder	   
			   $drink_image = $_FILES['image']['name'];
			   move_uploaded_file ($drink_image_temp, "../images/$drink_image");

			}
		} 
		
	   $add_drink_id = 1;//Id of menu image being updated
			 
	   if(empty($drink_image)){//If user does not change image keep current image
          
                 $drink_image = $old_image;
	    }
 
		 $stmt = mysqli_prepare($connection, "UPDATE drink_menu SET drink_menu_image = ?
		 WHERE drink_menu_id = ?");
		 
		 mysqli_stmt_bind_param($stmt,'si',$drink_image , $add_drink_id);
         mysqli_stmt_execute($stmt);

		 mysqli_stmt_close($stmt);//Close statment connection	
			   
			   	//Type of message
				$_SESSION['type'] = "alert alert-success";
				//Message content
				set_message("Menu Image Updated");
			    redirect("drink_menu.php");
	      }	
		
	?>
<!--Edit menu image  code end-->		
	
	<table class ="table table-bordered table-hover">
		<thead style="background-color:white;">
			<tr>
				<td></td>			
				<td>Drink Name</td>			
				<td>Edit Menu Item</td>
			</tr>
		</thead>

		<tbody style="background-color:white;">
	
	<?php 
	   
	   //Show drink items in menu  
	   $query ="SELECT 
		drinks.drink_id,
		drinks.drink_name,
		drinks.drink_description,
		drinks.drink_image,
		drinks.drink_price,
		drinks.drink_category_id,

		drink_menu.drink_menu_id,
		drink_menu.drink_id,
        drink_menu.drink_menu_image
		
		FROM drinks
									
		INNER JOIN drink_menu
		ON drinks.drink_id = drink_menu.drink_id  LIMIT {$number_in_drink_menu}";	

		$select_posts = mysqli_query($connection,$query);
	     
		 $count = 1 ;

		 //Show all the fields from the drinks table 
		while($row = mysqli_fetch_assoc($select_posts)){
		
	    $drink_id = escape($row['drink_id']);
	    $drink_ids [] = $drink_id ;//Used to test if updated menu items are duplicates
		
		$drink = escape($row['drink_menu_image']);
		
	    $drink_name = escape($row['drink_name']);	
		$drink_menu_id = escape($row['drink_menu_id']);
	
		//Id of the menu item 
		echo "<td>".$count."</td>";
		echo "<td>".$drink_name."</td>";		
	    echo "<td><a class='btn btn-info' href='drink_menu.php?drink_id={$drink_menu_id}'>Edit Menu Item</a></td>";//Use id of menu item to edit it
		
		$count ++;
		echo"</tr>";
		}
	?>
	
	</tbody>
	</table>
	</form>	
	<br>

	<?php
    
	//Used to filter the drink by drink category - send from edit menu button
	if(isset($_GET['drink_id'])){
		
		//Id of updating menu item	
	    $add_drink_id = escape($_GET['drink_id']);
		 
		?>
		
		<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 
		
		<div class = "form-group">
		<label for= "post_categories">Select Drink Category</label>
		<select name="drink_category" id="drink_category" class="form-control" >
		<?php
		
		 //Show a list of all the drink_category from database drink_category table after the user selects an option from the drop down menu
		 $stmt = mysqli_prepare($connection,"SELECT * FROM drink_category");
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
		<input class = "btn btn-primary" type = "submit" name = "add_drink" value="Find Drink" id ="add_drink">
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
	
	 //Page is used to edita drink  fromthe menu - is include for the drinks.php page
	if(isset($_POST["add_drink"])){ //Run when the page form is sent

	//Show a list all the drink of the selected category
	//Id of selected category
    $selected_category = escape($_POST['drink_category']);

	include("select_drinks.php");	
	
	}
	
	if(isset($_GET["selected_item_id"])){ //Run when the page form is sent

		    //Id of updating menu item and selected menu idem	
		    $add_drink_id = escape($_GET['drink_id']);     
		    $selected_item_id = escape($_GET['selected_item_id']);
	
			if(is_admin()){//Only logged in Admin users can edit code
																								 		 
				//Test if the added menu item is already in the menu - stops duplicate values being added - first value is tested value , secound is array
				//if (!in_array($add_drink_id, $drink_ids )) {
				if (false !== $key3 = array_search($add_drink_id, $drink_ids)) {
				   
				$drinkids = $key3 + 1; 
				
                //Type of message
				$_SESSION['type'] = "alert alert-danger";
				//Message content
				set_message("Drink exists in menu item ". $drinkids);

				redirect("drink_menu.php");	
						
				}else{//Update menu item
				  if(is_admin()){
					//Type of message
	                $_SESSION['type'] = "alert alert-success";
					//Message content
				    set_message("Menu item updated");
						
					//Query used to update the selected menu item
					$stmt = mysqli_prepare($connection, "UPDATE drink_menu SET drink_id = ? WHERE drink_menu_id = ? ");
					mysqli_stmt_bind_param($stmt, 'ii', $add_drink_id, $selected_item_id);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);//Close statment connection
					redirect("drink_menu.php");		
				  }		
				}

              }			
	    }
		
    ?>
 </div>
 <!-- /.container-fluid -->
 </div>	

<?Php

//Used to delete a drink
//Delete post function
if(isset($_GET['delete']) && !empty($_SESSION)){//If user has sent the delete parameter useing the delete buttons

	if(is_admin()){//Only logged in Admin users can edit code
																					 
		echo $the_drink_id = escape($_GET['delete']);
	
		$stmt = mysqli_prepare($connection, "DELETE FROM drinks WHERE drink_id  = ? ");
		mysqli_stmt_bind_param($stmt,'i',$the_drink_id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);//Close statment connection 
			
		redirect("drink_menu.php");//Refresh the page - the page needs to be refreshed for the delete to work   

	}
}

?>