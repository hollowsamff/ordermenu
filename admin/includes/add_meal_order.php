<script>
//Used to show the tool tip  - explains that the user needs to separate meal quality from order with commas
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
	
});

</script>

<!---
Used to add a meal order
-->

<div class="container-fluid">

   <div class="col-lg-12">

	<h2>Add Meal Order</h2>
	
	<?php //Show messages - the type SESSION stores what type of message it is -
	//Differnt warnings will apear depending on the type is set: for example a success class will be used if a a meal is updated
	if (!empty($_SESSION['message'])){
			
	dispay_message($_SESSION['type']);


	}	
	?>
								
	<?php $number_in_menu = 12;

    $_SESSION['menuitem'] = $number_in_menu;//Used to to the number in menu when show menu page loads
	$i = 0;

	?>
	
	 <!--Form which to add item to order -->
    <form action "" method ="post">
	<table class ="table table-bordered table-hover">
		
		<div id= "bulkOptionsContainer" style ="margin-left:-15px;"  class = "col-xs-4">
		<select class ="form-control" name = "bulk_options" id= "select">																	
		<option value="Add">Add</option>		
		</select>
		</div>

		<div class = "col-xs-4">
		<input type = "submit" name = "submit" id ="test" rel='1' class = "btn btn-success" value ="Add to Order">
		</div>
		<br><br>
	  <!--Form which to add item to order end-->
		
		<thead style="background-color:white;">
			<tr>
				<td><input  id = "select_All_Boxes" type ="checkbox"></td>			
				<td>Meal Name</td>						
			</tr>
		</thead>
		<tbody style="background-color:white;">
	
		<?php //Code is used to add multiple menu items to order 
			if(isset($_POST['check_box_array']) && !empty($_POST['check_box_array']) ){ 

			 $_SESSION['input_product']= "";
			 $_SESSION['input_meal_portions']= ""; 
			 $_SESSION['meal_price']= "";

			//Store all the send values from the tick boxes in array(the ids of the selected meals)
			foreach($_POST['check_box_array'] as $check_boxes_values  ){
					
			 $check_boxes_values = escape($check_boxes_values);//The value that was selected in the form that is used to add an order
	
		     $bulk_options = escape($_POST['bulk_options']);//Ids of selected items		
		
			 //Case what option was selected 
			 switch($bulk_options){
						 
				 case 'Add'://When the select option was add
				
				 ?>	
                    <!--Store order form-->                   					
					<form action = ""  multiple="multiple" method="post" enctype="multipart/form-data"><!-- --> 	
				
					<?php
			
					  //Show a list of all the meal_category from database meal_category table after the user selects an option from the drop down menu
					  //$stmt = mysqli_prepare($connection,"SELECT  meal_id , meal_name, meal_portions FROM meal WHERE meal_id =  ? ");
					  $stmt = mysqli_prepare($connection,"SELECT 
					    meal.meal_id,
						meal.meal_name,
						meal.meal_type_id,
						meal.meal_portions,

						meal_type.meal_type_id,
						meal_type.meal_type_name,
						meal_type.meal_type_cost

						FROM meal
												
						INNER JOIN meal_type
						ON meal.meal_type_id = meal_type.meal_type_id WHERE meal_id = ?");	
	  
					    mysqli_stmt_bind_param($stmt, "i" , $check_boxes_values);
				
					 if($stmt->execute()){
						
						//Bind these variable to the SQL results
						$stmt->bind_result($meal_id, $meal_name, $meal_type_id, $meal_portions, $meal_type_id2, $meal_type_name, $meal_type_cost);
						  
						while($stmt->fetch()){	
						
						     $meal_type_cost =  number_format(floor($meal_type_cost*100)/100,2, '.', '');
						 	
						     $_SESSION['meal_price'] .= $meal_type_cost."~";//Used to store  the price of the product at the time of sale	
		               	
							 $_SESSION['input_product'] .= $meal_id."~";//Store all the ids the meals ids in  session array - differnt items are seperated by ~ -
							 //Will use split string to input them meal into an order 
							
							 $_SESSION['input_meal_portions'] .= $meal_portions."~";//Used to update the portions of the sold item
							
							 $i++;
						}			
						
					 }
					 
					  mysqli_stmt_close($stmt);//Close statment connection 
						
					?>
							
					<input type="text" name="meal_name" id="meal_name" class="form-control" 
					autocomplete="on" value="<?php echo isset($meal_name) ? $meal_name : '' ;?>" readonly="value">
										
					<br>
				
				  <?php	
				  
				  break;
				
			  } //Close switch

			}
		  ?>	

				<input type="text" name="meal_quantity" id="meal_quantity" class="form-control" value="<?php $store_t ?>" placeholder="Item Quantity"
                  href="#" data-toggle="tooltip" title="Separate the values from the differnt meals with commas">
				<br>		
				<input style= "margin-right:5px;" class = "btn btn-primary" type = "submit" name = "update_order" value="Submit Order" id ="update_order" >
				<a class = "btn btn-primary" href ="orders.php?source=add_meal_order">Cancel Order</a>
				
				</form> 
				</div> 	  
				<br><br>
	
		<?php	  
			  
	     }//End add item to order code



if (isset($_POST['update_order'])){

//Create order when the store order form is submited

	$date = date("Y-m-d H:i:s");
	
	$stmt = mysqli_prepare($connection,"INSERT INTO orders(order_date) 
	VALUE(?)");
	mysqli_stmt_bind_param($stmt,'s',$date);
	mysqli_stmt_execute($stmt);

	$last_id = mysqli_insert_id($connection);//Id of input order
	
//Add meals from order to order_products table and update sold meal portions

     $split_string = explode('~',  $_SESSION['input_product']);//The differnt meal ids are seperated by ~ 
	 //An  explode is used to this split the text in to an array and the arrays values are input into the meal order meals table	

	 
	//Quantity of input item
	$number = escape($_POST['meal_quantity']);
	$split_number = explode(',',  $number );//Input the resived meal quantitys into an array - the number are seperate by commmas

	foreach($split_number as $key1){
		
		$inputnumber[] = $key1;		
	}	 
	 
	 	 
    //Current portions of meal  - used to updated the portions of the added meals - quantity of input item is added to this value
	$split_portions = explode('~',  $_SESSION['input_meal_portions']);

	foreach($split_portions as $key2){
		
	$input_portions[] = $key2;
	
	}	

	
	//Current price of meal - used to stop the orders price being changed when a user edits the meal type
	$split_price = explode('~',  $_SESSION['meal_price']);

	foreach($split_price as $key3){
		
	   $input_price[] = $key3;
				
	}	


	$i = 0 ;

	foreach($split_string as $key){//Loop runs for all the meals in the order -$key is meal id of added items

		//Input order items into user_order table in database
		$stmt2 = mysqli_prepare($connection,"INSERT INTO meal_order_meals(order_id, meal_id, item_quantity, product_price_at_sale) 
		VALUE(?,?,?,?)");
		
		mysqli_stmt_bind_param($stmt2,'iiid',$last_id, $key, $inputnumber[$i], $input_price[$i]);

		mysqli_stmt_execute($stmt2);

		mysqli_stmt_close($stmt2);//Close statment connection		
		
		//Update the quantity of the sold meals
	    $stmt3 = mysqli_prepare($connection,"UPDATE meal SET meal_portions = ? WHERE meal_id  = ?");			
        
		$updated_portions = $input_portions[$i] + $inputnumber[$i];//Old vale plus new value

		mysqli_stmt_bind_param($stmt3,'ii', $updated_portions, $key);

		mysqli_stmt_execute($stmt3);

		mysqli_stmt_close($stmt3);//Close statment connection
		
	$i++;	

		
	}

	
$_SESSION['input_product']= null;
$_SESSION['input_meal_portions']= null; 
$_SESSION['meal_price']= null;	
unset($_SESSION['meal_price']); 
unset($_SESSION['input_product']); 
unset($_SESSION['input_meal_portions']); 


//Type of message
$_SESSION['type'] = "alert alert-success";
//Message content
set_message("Order Submited");
//redirect("orders.php?source=add_meal_order");
	
}

?>
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
		ON meal.meal_id = food_menu.meal_id ORDER BY meal.meal_name LIMIT {$number_in_menu}";

		$select_posts = mysqli_query($connection,$query);
	     
	    $count = 1 ;
		//Show all the fields from the meals table 
		while($row = mysqli_fetch_assoc($select_posts)){
		
		$meal_id = escape($row['meal_id']);
		
	    ?>	
		 <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $meal_id?>'></td>					
		<?php //Stores the ids of the selected boxes in an array
		
	    
	    $meal_ids [] = $meal_id ;//Used to test if updated menu items are duplicates
		
	    $meal_name = escape($row['meal_name']);	

		//Id of the menu item 
		//echo "<td>".$count."</td>";
		echo "<td>".$meal_name."</td>";

		$count ++;
		echo"</tr>";	
		}

		
	?>
	

	</tbody>
	</table>
	</form>	
	<br>


 </div>
  
 <!-- /.container-fluid -->
 </div>	

