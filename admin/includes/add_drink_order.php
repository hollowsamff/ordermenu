<script>
//Used to show the tool tip  - explains that the user needs to separate drink quality from order with commas
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
	
});

</script>

<!---
Used to add a drink order
-->

<div class="container-fluid">

   <div class="col-lg-12">

	<h2>Add Drink Order</h2>
	
	<?php //Show messages - the type SESSION stores what type of message it is -
	//Differnt warnings will apear depending on the type is set: for example a success class will be used if a a drink is updated
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
				<td>Drink Name</td>						
			</tr>
		</thead>
		<tbody style="background-color:white;">
	
		<?php //Code is used to add multiple menu items to order 


			if(isset($_POST['check_box_array']) && !empty($_POST['check_box_array']) ){ 

			 $_SESSION['input_product']= "";
			 $_SESSION['input_drink_portions']="";
			 $_SESSION['drink_price'] =""; 
			  
			//Store all the send values from the tick boxes in array(the ids of the selected drinks)
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
			
					  //Show a list of all the drink_category from database drink_category table after the user selects an option from the drop down menu
					  $stmt = mysqli_prepare($connection,"SELECT  drink_id , drink_name, drink_portions, drink_price FROM drinks WHERE drink_id =  ? ");
					  mysqli_stmt_bind_param($stmt, "i" , $check_boxes_values);
				
					 if($stmt->execute()){
						
						//Bind these variable to the SQL results
						$stmt->bind_result($drink_id, $drink_name, $drink_portions, $drink_price);
						
									
						while($stmt->fetch()){	
							 
							 $drink_price =  number_format(floor($drink_price*100)/100,2, '.', '');
						 			 
						     $_SESSION['drink_price'] .= $drink_price."~";//Used to store  the price of the product at the time of sale
		
							 $_SESSION['input_product'] .= $drink_id."~";//Store all the ids the drinks ids in  session array - differnt items are seperated by ~ -
							 //Will use split string to input them drink into an order 
							
							 $_SESSION['input_drink_portions'] .= $drink_portions."~";//Used to update the portions of the sold item
							
							 $i++;
						}			
						
					 }
					 
					  mysqli_stmt_close($stmt);//Close statment connection 
						
					?>
							
					<input type="text" name="drink_name" id="drink_name" class="form-control" 
					autocomplete="on" value="<?php echo isset($drink_name) ? $drink_name : '' ;?>" readonly="value">
										
					<br>
				
				  <?php	
				  
				  break;
				
			  } //Close switch

			}
		  ?>	
				<input type="text" name="drink_quantity" id="drink_quantity" class="form-control" value="<?php $store_t ?>" placeholder="Item Quantity"
                  href="#" data-toggle="tooltip" title="Separate the values from the differnt drinks with commas">
				<br>		
				<input style= "margin-right:5px;" class = "btn btn-primary" type = "submit" name = "update_order" value="Submit Order" id ="update_order" >
				<a class = "btn btn-primary" href ="orders.php?source=add_drink_order">Cancel Order</a>
				
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
	
//Add drinks from order to order_products table and update sold drink portions

     $split_string = explode('~',  $_SESSION['input_product']);//The differnt drink ids are seperated by ~ 
	 //An  explode is used to this split the text in to an array and the arrays values are input into the drink order drinks table	

    //Current portions of drink  - used to updated the portions of the added drinks - quantity of input item is added to this value
	$split_portions = explode('~',  $_SESSION['input_drink_portions']);

	foreach($split_portions as $key2){
		
		$input_portions[] = $key2;
        		
	}	
	
	//Current price of drink  - used to stop the orders price being changed when a user edits the drink
	$split_price = explode('~',  $_SESSION['drink_price']);

	foreach($split_price as $key3){
		
		$input_price[] = $key3;
        		
	}	

	//Quantity of input item
	$number = escape($_POST['drink_quantity']);
	$split_number = explode(',',  $number );//Input the resived drink quantitys into an array - the number are seperate by commmas

	foreach($split_number as $key1){
		
		$inputnumber[] = $key1;		
	}
	
	$i = 0 ;

	foreach($split_string as $key){//Loop runs for all the drinks in the order -$key is drink id of added items

		//Input order items into user_order table in database
		$stmt2 = mysqli_prepare($connection,"INSERT INTO drink_order_drinks(order_id, drink_id ,item_quantity, product_price_at_sale) 
		VALUE(?,?,?,?)");
								 
		mysqli_stmt_bind_param($stmt2,'iiid',$last_id, $key, $inputnumber[$i] , $input_price[$i]);

		mysqli_stmt_execute($stmt2);

		mysqli_stmt_close($stmt2);//Close statment connection		
			
		//Update the quantity of the sold drinks
	    $stmt3 = mysqli_prepare($connection,"UPDATE drinks SET drink_portions = ? WHERE drink_id  = ?");			
        
		$updated_portions = $input_portions[$i] + $inputnumber[$i];//Old vale plus new value

		mysqli_stmt_bind_param($stmt3,'ii', $updated_portions, $key);

		mysqli_stmt_execute($stmt3);

		mysqli_stmt_close($stmt3);//Close statment connection
		
	$i++;	

		
	}
	
//Type of message
$_SESSION['type'] = "alert alert-success";
//Message content
set_message("Order Submited");
//redirect("orders.php?source=add_drink_order");
	
}

?>
	<?php 
	   
	   //Show drink items in menu  
	   $query ="SELECT 
	
		drinks.drink_id,
		drinks.drink_name,
		drinks.drink_description,
		drinks.drink_image,
		drinks.drink_price,
		drinks.drink_category_id,
		drinks.drink_portions,
		
		drink_menu.drink_menu_id,
		drink_menu.drink_id,
        drink_menu.drink_menu_image
		

		FROM drinks
									
		INNER JOIN drink_menu
		ON drinks.drink_id = drink_menu.drink_id ORDER BY drinks.drink_name LIMIT {$number_in_menu}";

		$select_posts = mysqli_query($connection,$query);
	     
	    $count = 1 ;
		//Show all the fields from the drinks table 
		while($row = mysqli_fetch_assoc($select_posts)){
		
		$drink_id = escape($row['drink_id']);
		
	    ?>	
		 <td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $drink_id?>'></td>					
		<?php //Stores the ids of the selected boxes in an array
		    
	    $drink_ids [] = $drink_id ;//Used to test if updated menu items are duplicates
		
	    $drink_name = escape($row['drink_name']);	

		//Id of the menu item 
		//echo "<td>".$count."</td>";
		echo "<td>".$drink_name."</td>";

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

