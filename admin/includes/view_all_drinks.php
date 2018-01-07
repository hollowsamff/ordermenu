<script> 

$('document').ready(function(){
	//Used to show the tool tip on the TAGS content box - explains that the user needs to separate tags with comas
	//$('[data-toggle="tooltip"]').tooltip(); 

});
</script>
<!--Page is used  to show all the drinks on the drinks.php page(is an include) -->

<?php //Code is used to change multiple drinks status and delete multiple drinks 
	include("delete_modal.php");

	//!empty($_SESSION stops query runing when page reloads
	if(isset($_POST['check_box_array']) && !empty($_POST['check_box_array']) ){ 

	//Store all the send values from the tick boxes in array(the ids of the selected drinks)
	foreach($_POST['check_box_array'] as $check_boxes_values  ){
		
	$check_boxes_values = escape($check_boxes_values);
		
	 //Value is the selected option from the bulk_options select
	$bulk_options = escape($_POST['bulk_options']);
				
	 //Case what option was selected 
	 switch($bulk_options){
		 
		case 'delete': // Delete selected drinks

			case 'delete': // Delete selected drinks
			
				if(is_admin()){//Only logged in Admin users can edit code
					
					$stmt = mysqli_prepare($connection, "DELETE FROM drinks WHERE drink_id  = ? ");
					mysqli_stmt_bind_param($stmt,'i',$check_boxes_values);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);//Close statment connection 
				}
				
         redirect("drinks.php");

		 break;
		 
		 
		 case 'clone': //Clone drinks

			  $stmt = mysqli_prepare($connection,"SELECT drink_id, drink_name, drink_description, drink_category_id, drink_image, drink_price,drink_portions
			  FROM drinks WHERE drink_id  = ? ");//Finds the post that was clonned
			 
			  mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
			  mysqli_stmt_execute($stmt);
			 
			  //Bind these variable to the SQL results
			  $stmt->bind_result($drink_id, $drink_name, $drink_description, $drink_category_id, $drink_image, $drink_price,$drink_portions);		
 
			  //Fetch will return all fow, so while will loop until reaches the end
			  while($stmt->fetch()){//Copy all the values from the drink back into the database
			
				 //Bind these variable to the SQL results
				 $drink_id = escape($drink_id);
				 $drink_name = escape($drink_name)."-copy";
				 $drink_description = escape($drink_description);
				 $drink_price =  escape($drink_price);
				 $drink_price =   number_format(floor($drink_price*100)/100,2, '.', '');
				 $drink_category_id = escape($drink_category_id);
				 $drink_image  = escape($drink_image);		
                 $drink_portions = escape($drink_portions);		
			   }		
				
			    mysqli_stmt_close($stmt);//Close statment
			   	
	           
			   if(is_admin()){//Only logged in Admin users can edit code
								
				   //Clone selected drinks
				   $stmt = mysqli_prepare($connection, "INSERT INTO drinks(drink_name, drink_description, drink_category_id, drink_price, drink_image, drink_portions) 
				   VALUES (?, ? , ? ,?,?,?)" ); 
				   mysqli_stmt_bind_param($stmt,'ssidsi',$drink_name, $drink_description, $drink_category_id, $drink_price, $drink_image, $drink_portions);
				   mysqli_stmt_execute($stmt);
				   mysqli_stmt_close($stmt);//Close statment connection 
				
				 
	          }
		
		redirect("drinks.php");
						
  		        echo"<br>";
   

		  break;
			 
	  } //Close switch

	}


	}

?>
						
 <!--Form which uses button and drop down menu to delete , the drinks -->
<form action "" method ="post">
<table class ="table table-bordered table-hover">

		<div id= "bulkOptionsContainer" style ="margin-left:-15px;"  class = "col-xs-4">
			<select class ="form-control" name = "bulk_options" id= "select">																	
			<option value="">Select Option</option>

			<option value="delete">Delete</option>
			<option value="clone">Clone</option>
		</select>
		</div>

		<div class = "col-xs-4">
		<input type = "submit" name = "submit" id ="test" rel='1' class = "btn btn-success" value ="Apply">
		<a class = "btn btn-primary" href="drinks.php?source=add_drink"> Add New </a>
		</div>
		<br><br>
		
		<!--Search for drinks by name-->
                <div class="well">
                    <h4>Drink Search</h4>
					<form action="" method="post">					
                    <div class="input-group">
                        <input name = "search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name = "submit2" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
					</form><!--Search form  -->
                    <!-- /.input-group -->
                </div>
				
				
				<?php //Show messages - the type SESSION stores what type of message it is -
				//Differnt warnings will apear depending on the type is set: for example a success class will be used if a a drink is updated
				if (!empty($_SESSION['message'])){
						
				dispay_message($_SESSION['type']);

				}	
				?>
		

<?php
//Used to find the meal the user searched for 
if(isset($_POST['submit2'])){
				
     $search = escape($_POST['search']); //Put the input search in a variable when the form is submited
     //echo"<br>";
	 
	if (empty($search)){//If the user input nothing redirect to this page
		
		
		//Type of message
		$_SESSION['type'] = "alert alert-danger";
		//Message content
		set_message("No drinks found");
		redirect("drinks.php");
	
	}
	
	$stmt = mysqli_prepare($connection, "SELECT drink_id
	FROM drinks WHERE drink_name LIKE '%$search%'");//Select all the values from the database
    
	//Find number of posts
	mysqli_stmt_execute($stmt);

	$stmt->bind_result($post_id);

	  while($stmt->fetch()){//Show meal loop
	  //Store result in array
	   $drink_found_id[] =  $post_id;
    
	  }
	  
	mysqli_stmt_close($stmt);  
}

?>
		<thead style="background-color:white;">
			<tr>
				<td><input  id = "select_All_Boxes" type ="checkbox"></td>
				
				<td>Drink Name</td>
				<td>Drink Description</td>
				<td>Drink Price</td>
				<td>Portions Sold</td>
				<td>Drink Image</td>
				<td>Drink Category</td>
				<td>Edit drink</td>
				<td>Delete drink</td>		
			
			</tr>
		</thead>

		<tbody style="background-color:white;">
		<?php 

		//Find all the drinks from database drink table
		//Uses double table join
		//drink.category_id links to drink_category table						
		$query ="SELECT 
		drinks.drink_id,
		drinks.drink_name,
		drinks.drink_description,
		drinks.drink_category_id,
		drinks.drink_price,
		drinks.drink_image,
		drinks.drink_portions,
		
		drink_category.drink_category_id,
		drink_category.drink_category_name

		FROM drinks

		INNER JOIN drink_category
		ON drinks.drink_category_id = drink_category.drink_category_id ";
		
		//IF a search  for meal has found result show that meal 
		global $drink_found_id;
		$i = 0;
		
        if(empty( $drink_found_id[0] )){//If no drink is found show all drinks
	        
			$query2 ="ORDER BY drinks.drink_name ASC";   
            $query3 = $query.$query2;
		
			$select_posts = mysqli_query($connection,$query3);

			//Show all the fields from the drinks table 
			while($row = mysqli_fetch_assoc($select_posts)){
				
			//Varables = the the values from the database
			$drink_id = escape($row['drink_id']);
			$drink_name = escape($row['drink_name']);
			$drink_description = escape($row['drink_description']);
			$drink_description =  stripslashes( $drink_description);
			$drink_category_id = escape($row['drink_category_id']);
			$drink_image = escape($row['drink_image']);
			$drink_price = escape($row['drink_price']);
			$drink_portions = escape($row['drink_portions']);
			
			$drink_category_id = escape($row['drink_category_id']);
			$drink_category_name = escape($row['drink_category_name']);
						
				 echo"<tr>";
				   ?>
				   <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $drink_id;?>'></td>
				
				   <?php //Stores the ids of the selected boxes in an array
				   
					echo"<td>$drink_name</td>";

					echo"<td>$drink_description</td>";
		
					echo"<td>&#163;$drink_price</td>";
					
					echo"<td>$drink_portions</td>";
					
					echo "<td> <img width='75'  src ='../images/$drink_image' alt='postimage'></td>";
			
					echo"<td>{$drink_category_name}</td>";
				
					echo "<td><a class='btn btn-info' href='drinks.php?source=edit_drink&p_id={$drink_id}'>Edit drink</td>";

					 //Delete works using the delete_link class
					 echo"<td><a class=' btn btn-danger delete_link'
					 rel='$drink_id' href='javascript:void(0)'>Delete</a> </td>";//Send the id of the selected post and number of comments to the .delete_link javascript function 
					 //Javascript creates a comfirmation box befor user deletes post - the delete function is run when comfirm is pressed and the selected post/comments are deleted				
					//With void(0) when you click delete link, the page is not refreshing which allows Javascript to show the Modal Window
					
			  }//End off code that show the drinks
			  
		}else{//Code to show meals from a search

			foreach($drink_found_id as $value ){//Loop though all the values in the array  that stores the drinks - show all the drinks from the array
						

				$query2 =" WHERE drinks.drink_id = {$drink_found_id[$i]}";
				$i++;
				
			    $query3 = $query.$query2;
				
				$select_posts = mysqli_query($connection,$query3);

				//Show all the fields from the drinks table 
				while($row = mysqli_fetch_assoc($select_posts)){
						
					//Varables = the the values from the database
					$drink_id = escape($row['drink_id']);
					$drink_name = escape($row['drink_name']);
					$drink_description = escape($row['drink_description']);
					$drink_category_id = escape($row['drink_category_id']);
					$drink_image = escape($row['drink_image']);
					$drink_price = escape($row['drink_price']);
					
					$drink_category_id = escape($row['drink_category_id']);
					$drink_category_name = escape($row['drink_category_name']);
								
						 echo"<tr>";
						   ?>
						   <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $drink_id;?>'></td>
						
						   <?php //Stores the ids of the selected boxes in an array
						   
							echo"<td>$drink_name</td>";

							echo"<td>$drink_description</td>";
							
							echo"<td>&#163;$drink_price</td>";
							echo "<td> <img width='75'  src ='../images/$drink_image' alt='postimage'></td>";

						
							echo"<td>{$drink_category_name}</td>";
						
							echo "<td><a class='btn btn-info' href='drinks.php?source=edit_drink&p_id={$drink_id}'>Edit drink</td>";

							 //Delete works using the delete_link class
							 echo"<td><a class=' btn btn-danger delete_link'
							 rel='$drink_id' href='javascript:void(0)'>Delete</a> </td>";//Send the id of the selected post and number of comments to the .delete_link javascript function 
							 //Javascript creates a comfirmation box befor user deletes post - the delete function is run when comfirm is pressed and the selected post/comments are deleted				
							//With void(0) when you click delete link, the page is not refreshing which allows Javascript to show the Modal Window
							
				  }//End off code that show the drinks
			}//End for each loop
		}//End else

		?>
</tbody>
</table>
</form>

		<?Php


		//Delete post function
		if(isset($_GET['delete']) && !empty($_SESSION)){//If user has sent the delete parameter useing the delete buttons

		if(is_admin()){//Only logged in Admin users can edit code
																							 
				echo $the_drink_id = escape($_GET['delete']);
	
			    $stmt = mysqli_prepare($connection, "DELETE FROM drinks WHERE drink_id  = ? ");
				mysqli_stmt_bind_param($stmt,'i',$the_drink_id);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);//Close statment connection 
					
			   redirect("drinks.php");//Refresh the page - the page needs to be refreshed for the delete to work   

		   }
		}

		?>


		<script> //Code used to make the delete function message box delete a post


		$(document).ready(function(){

		 $(".delete_link").on('click',function(){
			 
			var id = $(this).attr("rel");

			var delete_url = "drinks.php?delete="+ id; //Used to run the delete query for the post		
					 
			//Input the result in the delete model message
			$(".modal_delete_link").attr("href",delete_url);
			
			$('#myModal').modal('show')


		 });

		});//End of document.ready


		</script>
