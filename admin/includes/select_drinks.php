<!--Page is used to pick item for the drink menu(is an include on the menu_select page) -->

<?php //Code is used to change multiple drinks status and delete multiple drinks 
	include("delete_modal.php");
?>
						
 <!--Form which uses button and drop down menu to delete , the drinks -->
<form action "" method ="post">
<table class ="table table-bordered table-hover">

		<thead style="background-color:white;">
			<tr>
				<td><input  id = "select_All_Boxes" type ="checkbox"></td>
				<td>Drink Name</td>
				<td>Drink Description</td>
				<td>Drink Image</td>
				<td>Drink Category</td>
				<td>Add Drink to Menu</td>
				<td>Edit Drink</td>
				<td>Delete Drink</td>		
			</tr>
		</thead>

		<tbody style="background-color:white;">
		<?php 

		//Find all the drinks from database drink table

		//Uses triple table join
		//drink.drink_type_id links to drink_type table 
		//drink.category_id links to drink_category table						

		$query ="SELECT 
		drinks.drink_id,
		drinks.drink_name,
		drinks.drink_description,
		drinks.drink_image,
		drinks.drink_price,
		drinks.drink_category_id,
	
		drink_category.drink_category_id,
		drink_category.drink_category_name

		FROM drinks
									
		INNER JOIN drink_category
		ON drinks.drink_category_id = drink_category.drink_category_id 
		WHERE drink_category.drink_category_id={$selected_category} ORDER BY drinks.drink_id DESC ";

		$select_posts = mysqli_query($connection,$query);

		//Show all the fields from the drinks table 
		while($row = mysqli_fetch_assoc($select_posts)){
			
		//Varables = the the values from the database
		$drink_id = escape($row['drink_id']);
		$drink_name = escape($row['drink_name']);
		$drink_description = escape($row['drink_description']);
		$drink_image = escape($row['drink_image']);
		$drink_category_id = escape($row['drink_category_id']);
		$drink_category_name = escape($row['drink_category_name']);

			   echo"<tr>";
			   ?>
			   <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $drink_id;?>'></td>
			
			   <?php //Stores the ids of the selected boxes in an array
			   
			    echo"<td>$drink_name</td>";

				echo"<td>$drink_description</td>";				
			
				echo "<td> <img width='75'  src ='../images/$drink_image' alt='postimage'></td>";

				echo"<td>{$drink_category_name}</td>";
				
		        echo "<td><a class='btn btn-info' href='drink_menu.php?drink_id={$drink_id}&selected_item_id={$add_drink_id}'>Add to Menu</td>";
                //Used to add the selected item to the selected menu item 
				
				echo "<td><a class='btn btn-info' href='drinks.php?source=edit_drink&p_id={$drink_id}'>Edit drink</td>";

            	 //Delete works using the delete_link class
				 echo"<td><a class=' btn btn-danger delete_link'
				 rel='{$drink_id}' href='javascript:void(0)'>Delete</a> </td>";//Send the id of the selected post and number of comments to the .delete_link javascript function 
				 //Javascript creates a comfirmation box befor user deletes post - the delete function is run when comfirm is pressed and the selected post/comments are deleted
				 //With void(0) when you click delete link, the page is not refreshing which allows Javascript to show the Modal Window
			
				 echo"</tr>";

		}//End off code that show the drinks

		?>
</tbody>
</table>
</form>

<script> //Code used to make the delete function message box delete a post

$(document).ready(function(){

 $(".delete_link").on('click',function(){
	 
	var id = $(this).attr("rel");

	var delete_url = "drink_menu.php?delete="+ id; //Used to run the delete query for the post		
	
	//Input the result in the delete model message
	$(".modal_delete_link").attr("href",delete_url);
	
	$('#myModal').modal('show')

 });

});//End of document.ready


</script>