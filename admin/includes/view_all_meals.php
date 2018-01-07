<script> 

$('document').ready(function(){
	//Used to show the tool tip on the TAGS content box - explains that the user needs to separate tags with comas
	//$('[data-toggle="tooltip"]').tooltip(); 

});
</script>
<!--Page is used  to show all the meals on the meals.php page(is an include) -->

<?php //Code is used to change multiple meals status and delete multiple meals 
	include("delete_modal.php");

	//!empty($_SESSION stops query runing when page reloads
	if(isset($_POST['check_box_array']) && !empty($_POST['check_box_array']) ){ 

	//Store all the send values from the tick boxes in array(the ids of the selected meals)
	foreach($_POST['check_box_array'] as $check_boxes_values  ){
		
	$check_boxes_values = escape($check_boxes_values);
		
	 //Value is the selected option from the bulk_options select
	$bulk_options = escape($_POST['bulk_options']);
				
	 //Case what option was selected 
	 switch($bulk_options){
		 
		case 'delete': // Delete selected meals

			case 'delete': // Delete selected meals
			//Only admins can edit code
			if(is_admin()){ 
			    //Delete meal and meal_allergy
				$stmt = mysqli_prepare($connection, "DELETE FROM allergy_meal  WHERE meal_id  = ? ");
				mysqli_stmt_bind_param($stmt,'i',$check_boxes_values);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);//Close statment connection 
				
			    $stmt = mysqli_prepare($connection, "DELETE FROM meal WHERE meal_id  = ? ");
				mysqli_stmt_bind_param($stmt,'i',$check_boxes_values);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);//Close statment connection 
          }

         redirect("meals.php");

		 break;
		 
		 
		 case 'clone': //Clone meals
			//Only admins can edit code
			if(is_admin()){
			  $stmt = mysqli_prepare($connection,"SELECT meal_id, meal_name, meal_description, meal_type_id, meal_portions, category_id, meal_image
			  FROM meal WHERE meal_id  = ? ");//Finds the post that was clonned
			 
			  mysqli_stmt_bind_param($stmt,'i',$check_boxes_values );
			  mysqli_stmt_execute($stmt);
			 
			  //Bind these variable to the SQL results
			  $stmt->bind_result($meal_id, $meal_name, $meal_description, $meal_type, $meal_portions, $meal_category, $meal_image);		
 
			  //Fetch will return all fow, so while will loop until reaches the end
			  while($stmt->fetch()){//Copy all the values from the meal back into the database
			
				 //Bind these variable to the SQL results
				 $meal_id = escape($meal_id);
				 $meal_name = escape($meal_name)."-copy";
				 $meal_description = escape($meal_description);
				 $meal_description =  stripslashes( $meal_description);
				 $meal_type =  escape($meal_type);
				 $meal_portions= escape($meal_portions);
				 $meal_category = escape($meal_category);
				 $meal_image  = escape($meal_image);		
 
			   }		
				
			    mysqli_stmt_close($stmt);//Close statment
			   		   	   
			   //Clone selected meals
               $stmt = mysqli_prepare($connection, "INSERT INTO meal(meal_name, meal_description, meal_type_id, meal_portions, category_id, meal_image) 
			   VALUES (?, ? , ? ,?,?,? )" ); 
			   mysqli_stmt_bind_param($stmt,'ssiiis',$meal_name, $meal_description, $meal_type, $meal_portions, $meal_category, $meal_image);
			   mysqli_stmt_execute($stmt);
			   mysqli_stmt_close($stmt);//Close statment connection 
			 	

                ////////////////Clone categorys from meal				
			    $New_id = mysqli_insert_id($connection);//Id of the input last meal
			 			
	           //Query to find the allergys of the clonned post 
				$query ="SELECT 
				allergy_meal.alergy_id,
				allergy_meal.meal_id,
				allergy_meal.allergy_meal_id,
						
				allergy.allergry_id,
				allergy.allergy_name

				FROM allergy_meal		
				INNER JOIN allergy
				
				ON allergy_meal.alergy_id = allergy.allergry_id WHERE allergy_meal.meal_id =".$meal_id." ";
						
				$select_posts = mysqli_query($connection,$query);

				//Use a loop to input all the meal allergys of the clonned posts into the database meal_allergy table
				while($row = mysqli_fetch_assoc($select_posts)){

				$allergy_meal_id  = escape($row['allergry_id']);
				$allergy_meal_name = escape($row['allergy_name']);
				
				$stmt = mysqli_prepare($connection, "INSERT INTO allergy_meal(alergy_id, meal_id) 
			    VALUES (?,?)" );//The values are input into 
						
				 mysqli_stmt_bind_param($stmt,'ii',$allergy_meal_id ,$New_id);

			     mysqli_stmt_execute($stmt);
			
				}
				
				redirect("meals.php");
						
  		        echo"<br>";
   
			}
		  break;
			 
	  } //Close switch

	}


	}

?>
						
 <!--Form which uses button and drop down menu to delete , the meals -->
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
		<a class = "btn btn-primary" href="meals.php?source=add_meal"> Add New </a>
		</div>
		<br><br>
	
				<!--Search for meals by name-->
                <div class="well">
                    <h4>Meal Search</h4>
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
		set_message("No meals found");
		redirect("meals.php");
	
	}
	
	$stmt = mysqli_prepare($connection, "SELECT meal_id
	FROM meal WHERE meal_name LIKE '%$search%'");//Select all the values from the database
    
	//Find number of posts
	mysqli_stmt_execute($stmt);

	$stmt->bind_result($post_id);

	  while($stmt->fetch()){//Show meal loop
	  //Store result in array
	   $meal_found_id[] =  $post_id;
    
	  }
	  
	mysqli_stmt_close($stmt);  
}

?>
			
		<thead style="background-color:white;">
			<tr>
				<td><input  id = "select_All_Boxes" type ="checkbox"></td>
				
				<td>Meal Name</td>
				<td>Meal Description</td>
				<td>Portions Sold</td>
				<td>Meal Image</td>
				<td>Meal Type</td>
				<td>Meal Category</td>
				<td>Edit Meal</td>
				<td>Delete Meal</td>
				<td>Meal Allergys</td>		
			
			</tr>
		</thead>

		<tbody style="background-color:white;">
		<?php 

		//Find all the meals from database meal table

		//Uses triple table join
		//meal.meal_type_id links to meal_type table 
		//meal.category_id links to meal_category table						

		$query ="SELECT 
		meal.meal_id,
		meal.meal_name,
		meal.meal_description,
		meal.meal_type_id,
		meal.meal_portions,
		meal.category_id,
		meal.meal_image,
		
		meal_category.meal_category_id,
		meal_category.meal_category_name,

		meal_type.meal_type_id,
		meal_type.meal_type_name

		FROM meal
									
		INNER JOIN meal_category
		ON meal.category_id = meal_category.meal_category_id ";
		
		//IF a search  for meal has found result show that meal 
		global $meal_found_id;

		$i = 0;
		
        if(empty($meal_found_id[0])){//If no meal is found show all meals
	
			$query2 =" INNER JOIN meal_type ON meal.meal_type_id = meal_type.meal_type_id ORDER BY meal.meal_name ASC";	    
            $query3 = $query.$query2;
				
				$select_posts = mysqli_query($connection,$query3);
				
				//Show all the fields from the meals table 
				while($row = mysqli_fetch_assoc($select_posts)){
						
					//Varables = the the values from the database
					$meal_id = escape($row['meal_id']);
					$meal_name = escape($row['meal_name']);
					$meal_description = escape($row['meal_description']);
					$meal_type_id = escape($row['meal_type_id']);
					$meal_portions = escape($row['meal_portions']);
					$meal_category_id = escape($row['category_id']);
					$meal_image = escape($row['meal_image']);
					$meal_category_id = escape($row['meal_category_id']);
					$meal_category_name = escape($row['meal_category_name']);
					$meal_type_id = escape($row['meal_type_id']);
					$meal_type_name = escape($row['meal_type_name']);
				
						//Find the allergys for one meal - use inner join to show the allergy names 											
						$query2 ="SELECT 
										
						allergy_meal.alergy_id,
						allergy_meal.meal_id,
						allergy_meal.allergy_meal_id,
							
						allergy.allergry_id,
						allergy.allergy_name
						
						FROM allergy_meal
						
						INNER JOIN allergy
						ON allergy_meal.alergy_id = allergy.allergry_id WHERE allergy_meal.meal_id = {$meal_id}";
													
						$stmt2 = $connection->prepare( $query2 );

						if($stmt2->execute()){ 
						
							// Bind these variable to the SQL results
							$stmt2->bind_result(
							$meal_image2,
							$meal_category_id2,
							$meal_category_name2,
							$meal_allery_id,
							$meal_allery_name);
						}       									
						
						 echo"<tr>";
						   ?>
						   <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $meal_id;?>'></td>
						
						   <?php //Stores the ids of the selected boxes in an array
						   
							echo"<td>$meal_name</td>";

							echo"<td>$meal_description</td>";
							
							echo"<td>$meal_portions</td>";

							echo "<td> <img width='75'  src ='../images/$meal_image' alt='postimage'></td>";

							echo"<td>{$meal_type_name}</td>";
							echo"<td>{$meal_category_name}</td>";
						
							echo "<td><a class='btn btn-info' href='meals.php?source=edit_meal&p_id={$meal_id}'>Edit Meal</td>";

							 //Delete works using the delete_link class
							 echo"<td><a class=' btn btn-danger delete_link'
							 rel='$meal_id' href='javascript:void(0)'>Delete</a> </td>";//Send the id of the selected post and number of comments to the .delete_link javascript function 
							 //Javascript creates a comfirmation box befor user deletes post - the delete function is run when comfirm is pressed and the selected post/comments are deleted
							 //With void(0) when you click delete link, the page is not refreshing which allows Javascript to show the Modal Window

						   //Show all the fields from the meal allergy from the meal_allergy table - uses query2   
							echo "<td>";
							while($stmt2->fetch()){

							echo $meal_allery_name.", ";

							}echo "</td>";
										
							echo"</tr>";

				}//End select row code	
				
				
		}else{//Code to show meals from a search
	         		 
			foreach($meal_found_id as $value ){//Loop though all the values in the array  that stores the meals - show all the meal from th array
						 	 
			    $query2 =" INNER JOIN meal_type ON meal.meal_type_id = meal_type.meal_type_id WHERE meal.meal_id = {$meal_found_id[$i]}";
				$i++;
				
				$query3 = $query.$query2;
				
				$select_posts = mysqli_query($connection,$query3);
				
				//Show all the fields from the meals table 
				while($row = mysqli_fetch_assoc($select_posts)){
						
					//Varables = the the values from the database
					$meal_id = escape($row['meal_id']);
					$meal_name = escape($row['meal_name']);
					$meal_description = escape($row['meal_description']);
					$meal_type_id = escape($row['meal_type_id']);
					$meal_portions = escape($row['meal_portions']);
					$meal_category_id = escape($row['category_id']);
					$meal_image = escape($row['meal_image']);
					$meal_category_id = escape($row['meal_category_id']);
					$meal_category_name = escape($row['meal_category_name']);
					$meal_type_id = escape($row['meal_type_id']);
					$meal_type_name = escape($row['meal_type_name']);
				
						//Find the allergys for one meal - use inner join to show the allergy names 											
						$query2 ="SELECT 
										
						allergy_meal.alergy_id,
						allergy_meal.meal_id,
						allergy_meal.allergy_meal_id,
							
						allergy.allergry_id,
						allergy.allergy_name
						
						FROM allergy_meal
						
						INNER JOIN allergy
						ON allergy_meal.alergy_id = allergy.allergry_id WHERE allergy_meal.meal_id = {$meal_id}";
													
						$stmt2 = $connection->prepare( $query2 );

						if($stmt2->execute()){ 
						
								// Bind these variable to the SQL results
								$stmt2->bind_result(
								$meal_image2,
								$meal_category_id2,
								$meal_category_name2,
								$meal_allery_id,
								$meal_allery_name);
						}       
														
						 echo"<tr>";
						   ?>
						   <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $meal_id;?>'></td>
						
						   <?php //Stores the ids of the selected boxes in an array
						   
							echo"<td>$meal_name</td>";

							echo"<td>$meal_description</td>";
							
							echo"<td>$meal_portions</td>";

							echo "<td> <img width='75'  src ='../images/$meal_image' alt='postimage'></td>";

							echo"<td>{$meal_type_name}</td>";
							echo"<td>{$meal_category_name}</td>";
						
							echo "<td><a class='btn btn-info' href='meals.php?source=edit_meal&p_id={$meal_id}'>Edit Meal</td>";

							 //Delete works using the delete_link class
							 echo"<td><a class=' btn btn-danger delete_link'
							 rel='$meal_id' href='javascript:void(0)'>Delete</a> </td>";//Send the id of the selected post and number of comments to the .delete_link javascript function 
							 //Javascript creates a comfirmation box befor user deletes post - the delete function is run when comfirm is pressed and the selected post/comments are deleted
							 //With void(0) when you click delete link, the page is not refreshing which allows Javascript to show the Modal Window

							 //Show all the fields from the meal allergy from the meal_allergy table - uses query2   
							 echo "<td>";
							 while($stmt2->fetch()){

							 echo $meal_allery_name.", ";

							 }echo "</td>";
										
							 echo"</tr>";

				}//End select row code
			  }
         }//End else to show results from search
		?>
</tbody>
</table>
</form>

		<?Php


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
					
			   redirect("meals.php");//Refresh the page - the page needs to be refreshed for the delete to work   

		}
		}
		
		?>


		<script> //Code used to make the delete function message box delete a post


		$(document).ready(function(){

		 $(".delete_link").on('click',function(){
			 
			var id = $(this).attr("rel");

			var delete_url = "meals.php?delete="+ id; //Used to run the delete query for the post		
						 
			//Input the result in the delete model message
			$(".modal_delete_link").attr("href",delete_url);
			
			$('#myModal').modal('show')


		 });

		});//End of document.ready


		</script>
