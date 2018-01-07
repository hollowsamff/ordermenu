<!--Page is used to pick item for the food menu(is an include on the menu_select page) -->

<?php //Code is used to change multiple meals status and delete multiple meals 
	include("delete_modal.php");
?>
						
 <!--Form which uses button and drop down menu to delete , the meals -->
<form action "" method ="post">
<table class ="table table-bordered table-hover">

		<thead style="background-color:white;">
			<tr>
				<td><input  id = "select_All_Boxes" type ="checkbox"></td>
				
				<td>Meal Name</td>
				<td>Meal Description</td>
				<td>Meal Portions</td>
				<td>Meal Image</td>
				<td>Meal Type</td>
				<td>Meal Category</td>
				<td>Add Meal to Menu</td>
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
		ON meal.category_id = meal_category.meal_category_id

		INNER JOIN meal_type
		ON meal.meal_type_id = meal_type.meal_type_id WHERE meal_category.meal_category_id={$selected_category} ORDER BY meal.meal_id DESC ";

		$select_posts = mysqli_query($connection,$query);

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
				
		        echo "<td><a class='btn btn-info' href='menu.php?meal_id={$meal_id}&selected_item_id={$add_meal_id}'>Add to Menu</td>";
                //Used to add the selected item to the selected menu item 
				
				echo "<td><a class='btn btn-info' href='meals.php?source=edit_meal&p_id={$meal_id}'>Edit Meal</td>";

            	 //Delete works using the delete_link class
				 echo"<td><a class=' btn btn-danger delete_link'
				 rel='{$meal_id}' href='javascript:void(0)'>Delete</a> </td>";//Send the id of the selected post and number of comments to the .delete_link javascript function 
				 //Javascript creates a comfirmation box befor user deletes post - the delete function is run when comfirm is pressed and the selected post/comments are deleted
				 //With void(0) when you click delete link, the page is not refreshing which allows Javascript to show the Modal Window

			     //Show all the fields from the meal allergy from the meal_allergy table - uses query2   
				 echo "<td>";
				 while($stmt2->fetch()){

				    echo $meal_allery_name." ";

				 }echo "</td>";
							
				 echo"</tr>";

		}//End off code that show the meals

		?>
</tbody>
</table>
</form>

<script> //Code used to make the delete function message box delete a post

$(document).ready(function(){

 $(".delete_link").on('click',function(){
	 
	var id = $(this).attr("rel");

	var delete_url = "menu.php?delete="+ id; //Used to run the delete query for the post		
	
	//Input the result in the delete model message
	$(".modal_delete_link").attr("href",delete_url);
	
	$('#myModal').modal('show')

 });

});//End of document.ready


</script>