<?php

//Used to test if logged in user is admin - used on the user page in admin
function  is_admin(){
	
global $connection;

if(isset($_SESSION['user_role']) && !empty($_SESSION['user_role']) &&  $_SESSION['user_role'] == 'Admin' ){ 

		return true;

	   }else{
			
	    return false;
	  }
			
}

//Used to set error messages
function set_message($msg){
	
	if ( !empty($msg) ){
		
	$_SESSION['message'] = $msg;

	}else{
		
		$msg = "";

	}
	
}
//Used to show error messages
function dispay_message($type){
				
      if ( isset($_SESSION['message']) ) {
	
		echo "<p class='{$type}'>".$_SESSION['message']."</p>";
		unset($_SESSION['message']);
	}
}


		
function login_user($username,$password){
	
	global $connection;	

	$username = escape($_POST['username'] );
	$password = escape( $_POST['password']);
	
	//When the user inputs nothing in to the boxes reload index page
	if (empty($password) || empty($username)){ 
	redirect("../blog.php"); 
	}
	
	$stmt = mysqli_prepare($connection,"SELECT user_last_name, user_first_name, user_id,user_name, user_password, user_role FROM users where user_name = (?)");
    mysqli_stmt_bind_param($stmt,'s' , $username);
	//if( !$stmt ) exit('Error'. htmlspecialchars($db->error));

	mysqli_stmt_execute($stmt);
	
	//Bind these variable to the SQL results
	$stmt->bind_result($db_last_name , $db_user_first_name , $db_user_id, $db_user_name, $db_password, $db_user_role);
		
	//Fetch will return all fow, so while will loop until reaches the end
	while($stmt->fetch()){
		
		//Use password_verify to decrypt blowfish password - uses original password and database password
		if (password_verify($password,$db_password )){
			
			    //Set server session cookies
				$_SESSION['user_first_name'] = $db_user_first_name ;
				$_SESSION['user_last_name'] = $db_last_name ;
				$_SESSION['user_role'] = $db_user_role ;
				$_SESSION['user_name'] = $db_user_name;	
				$_SESSION['user_id'] = $db_user_id;	
				
				mysqli_stmt_close($stmt);//Close statment connection 
				redirect("../admin/index.php");
				return;
				
			}else{//When password is wrong for found account reload index page
			
			mysqli_stmt_close($stmt);//Close statment connection 
			redirect("../index.php");
			
			}
			
	      }//End of code when the stmt does not run
		  
		  redirect("../index.php");//When the username is not found  reload index page
      //}

}//End function		



//Function used to create a website account	
function regester_user($username,$email,$password){
		
	   global $connection;
	
       $username =  escape($username);
	   $email =  escape($email);
       $password =  escape($password);
       $role = "Admin";//the website has two user types ("Admin and Subscriber") The web has the functionality to control what different user see in the content management system if the client wants;
	   //.i.e. they could use this functionality to only allow serving staff to access to the  CMS order pages       
 
	   //Use blowfish to hash the password - first value is password variable , second is encryption type and third is number of time hash will be run
	   $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
	
	   $stmt = mysqli_prepare($connection, "INSERT INTO users(user_name, user_password, user_email, user_role) VALUES (?, ? , ? ,?)" );
	   
	   mysqli_stmt_bind_param($stmt,'ssss',$username,  $password, $email  ,$role );

	   mysqli_stmt_execute($stmt);
	   
	   //if(!$stmt){die("Query error"); }

	   mysqli_stmt_close($stmt);//Close statment connection 	
 }



//Stops users creating accounts with the same username
function user_name_exists($username){
	global $connection;

	$stmt = mysqli_prepare($connection,"SELECT user_id FROM users WHERE user_name = ? ");
	
    mysqli_stmt_bind_param($stmt,'s', $username);
	
	mysqli_stmt_execute($stmt);
	
    mysqli_stmt_store_result($stmt);//Store result 
	
	$find_name_result = mysqli_stmt_num_rows($stmt);
	
	if ($find_name_result > 0){
		
		return true;
		
	}else{
		
		return false;
		
	}
	
}


//Stops users creating accounts with the same email
function user_email_exists($user_email){
	
	global $connection;		
	$stmt = mysqli_prepare($connection,"SELECT user_id FROM users WHERE user_email = ? ");
	
	mysqli_stmt_bind_param($stmt,'s', $user_email);
	mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);//Store result 
	
	$find_email = mysqli_stmt_num_rows($stmt);

	
	if ($find_email > 0){
		
		return true;
		
	}else{
		
		return false;
		
	}
	
}



//Used to redirect the user to differnt pages
function redirect($location){
	return header("Location:" . $location);
}


//Function is used to test if other functions work
function confirm_query($result){
	
   global $connection;
	 
   if (!$result){//Validation to test if data is input into database 
		
		die('Query failed');
		
	    }
}

//Function used to stop SQL attacks - remove bad thing from strings sent to function
function escape($string){

	global $connection;
	$string = mb_convert_encoding($string, 'UTF-8', 'UTF-8'); //Stop user inputing other languages	
	$string   = stripslashes($string);
	return mysqli_real_escape_string($connection, trim(strip_tags($string)));
	
}

//Function used to stop SQL attacks - used for content whcih needs tags e.g text that contains multiple lines
function escape2($string){

	global $connection;
	$string = mb_convert_encoding($string, 'UTF-8', 'UTF-8'); //Stop user inputing other languages	
	return mysqli_real_escape_string($connection, trim(($string)));
	
}

///Drinks

//Function is used to add a  drink categories to the database - function is used on the drink categories.php page
function insert_drink_categories(){

//Only admins can edit code
if(is_admin()){
	
	 global $connection;

	 //Used to add category to database
	 if(isset($_POST["submit"])){//Uses POST from add category form
		
		  $drink_title = escape($_POST['drink_title']);	

			if($drink_title == "" || empty($drink_title)){//Test if the value is blank
			  
			  echo"<h4 class='warning_red'>Drink Category shoud not be empty!</h4>";
				
			}else{//Insert value into database categories table
				
		//Use function to test if the category exists
		if (drink_categories_exists($drink_title) !== false)//check if the return value is EXACTLY false, so the type is required to be boolean.
		{
			echo"<h4 class='warning_red'>Drink catagory already exists!</h4>";

		}else{
				$stmt= mysqli_prepare($connection,"INSERT INTO drink_category(drink_category_name) VALUE(?) ");
				mysqli_stmt_bind_param($stmt,'s' , $drink_title);
				mysqli_stmt_execute($stmt);
				
				if(!$stmt){//Test if the query fails
					
						//die("Query error")."<br>". mysqli_error($stmt);
				  }	
				
				mysqli_stmt_close($stmt);//Close statment connection 
			    redirect("drink_categories.php");
			
				}
				
			}
	  } 
		
 }

}

//Stops stop user inputing duplicate meal categories on the meal_category.php page
function drink_categories_exists($drink_title){
	
	global $connection;
	
    $drink_title = escape($drink_title);

	$stmt3 = mysqli_prepare($connection,"SELECT drink_category_id FROM drink_category WHERE drink_category_name = ? ");
	
	mysqli_stmt_bind_param($stmt3,'s', $drink_title);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_store_result($stmt3);//Store result 
	
	$find_categories = mysqli_stmt_num_rows($stmt3);

	if ($find_categories > 0){
		
		return true;
			
	}else{

		return false;
	
		
	}
		mysqli_stmt_close($stmt3);//Close statment connection 
	
}   
/////////////////////////////////////////Drinks end
	

/////////////////////////////////////////Meals

//Function is used to add a  meal categories to the database - function is used on the categories.php page
function insert_categories(){
//Only admins can edit code
if(is_admin()){
	 global $connection;

	 //Used to add category to database
	 if(isset($_POST["submit"])){//Uses POST from add category form
		
		  $cat_title = escape($_POST['cat_title']);	

			if($cat_title == "" || empty($cat_title)){//Test if the value is blank
			  
			  echo"<h4 class='warning_red'>Add Category shoud not be empty!</h4>";
				
			}else{//Insert value into database categories table
				
		//Use function to test if the category exists
		if (categories_exists($cat_title) !== false)//check if the return value is EXACTLY false, so the type is required to be boolean.
		{
			echo"<h4 class='warning_red'>Catagory already exists!</h4>";

		}else{
				$stmt= mysqli_prepare($connection,"INSERT INTO meal_category(meal_category_name) VALUE(?) ");
				mysqli_stmt_bind_param($stmt,'s' , $cat_title);
				mysqli_stmt_execute($stmt);
				
				if(!$stmt){//Test if the query fails
					
						//die("Query error")."<br>". mysqli_error($stmt);
				  }	
				
				mysqli_stmt_close($stmt);//Close statment connection 
			    redirect("meal_categories.php");
			
				}
				
			}
	  } 
		
 }
	   
}

//Stops stop user inputing duplicate meal categories on the meal_category.php page
function categories_exists($cat_title){
	
	global $connection;
	
    $cat_title = escape($cat_title);

	$stmt3 = mysqli_prepare($connection,"SELECT meal_category_id FROM meal_category WHERE meal_category_name = ? ");
	
	mysqli_stmt_bind_param($stmt3,'s', $cat_title);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_store_result($stmt3);//Store result 
	
	$find_categories = mysqli_stmt_num_rows($stmt3);

	if ($find_categories > 0){
		
		return true;
			
	}else{

		return false;
	
		
	}
		mysqli_stmt_close($stmt3);//Close statment connection 
	
}   
	
//Function is used to add a  meal type to the database - function is used on the categories.php page
function insert_meal_type(){
//Only admins can edit code
if(is_admin()){
	 global $connection;

	 //Used to add category to database
	 if(isset($_POST["submitmealtype"])){//Uses POST from add category form
		
		 $meal_title = escape($_POST['meal_title']);	
	     $meal_price = escape($_POST['price']);	
		 $meal_price =   number_format(floor($meal_price*100)/100,2, '.', '');
         $meal_price  = floatval($meal_price);
		 	 
			if($meal_title == "" || empty($meal_title)){//Test if the value is blank
			  
			  echo"<h4 class='warning_red'>Add meal shoud not be empty!</h4>";
				
			}else{//Insert value into database categories table
				
		//Use function to test if the category exists
		if (meal_type_exists($meal_title) !== false)//check if the return value is EXACTLY false, so the type is required to be boolean.
		{
			echo"<h4 class='warning_red'>Meal type already exists!</h4>";

		}else{
				$stmt= mysqli_prepare($connection,"INSERT INTO meal_type(meal_type_name, meal_type_cost) VALUE(?,?) ");
				mysqli_stmt_bind_param($stmt,'sd' , $meal_title,$meal_price );
				mysqli_stmt_execute($stmt);
				
				if(!$stmt){//Test if the query fails
					
						//die("Query error")."<br>". mysqli_error($stmt);
				  }	
				
				mysqli_stmt_close($stmt);//Close statment connection 
			    redirect("meal_categories.php");
			
				}
				
			}
	  } 
		
 }
	
}
	
//Stops stop user inputing duplicate meal types on the categories.php page
function meal_type_exists($meal_title){
	
	global $connection;
	
	$meal_title = escape($meal_title);	

	$stmt3 = mysqli_prepare($connection,"SELECT meal_type_id FROM meal_type WHERE meal_type_name = ? ");
	
	mysqli_stmt_bind_param($stmt3,'s', $meal_title);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_store_result($stmt3);//Store result 
	
	$find_categories = mysqli_stmt_num_rows($stmt3);

	if ($find_categories > 0){
		
		return true;
			
	}else{

		return false;
	}
		mysqli_stmt_close($stmt3);//Close statment connection 
	
}  

/////////////////////////////////////////Meals end


///////////////////////Allergys

//Function is used to add a  allergy to the database - function is used on the allergy  page
function insert_allergy(){
//Only admins can edit code
if(is_admin()){
	
	 global $connection;

	 //Used to add category to database
	 if(isset($_POST["submit"])){//Uses POST from add category form
		
		           $allergy_name =  escape($_POST["allergy_name"]);
				   $allergy_description = escape($_POST["allergy_description"]);
				   $allergy_description = stripslashes($allergy_description);
			
		if( $allergy_name == "" || empty( $allergy_name) || $allergy_description == "" || empty( $allergy_description)){//Test if the value is blank
  
  
  
  
			echo"<h4 class='warning_red'>Fields cannot be empty!</h4>";
			
		}else{//Insert value into database categories table
						
		//Use function to test if the category exists
		if (allergy_exists($allergy_name) !== false)//check if the return value is EXACTLY false, so the type is required to be boolean.
		{
			echo"<h4 class='warning_red'>Allergy already exists!</h4>";

		}else{
				if(is_admin()){//Only logged in Admin users can edit code
						
					$stmt= mysqli_prepare($connection,"INSERT INTO allergy(allergy_name, allergy_description) VALUE(?,?) ");
					mysqli_stmt_bind_param($stmt,'ss' , $allergy_name, $allergy_description);
					mysqli_stmt_execute($stmt);
					
					if(!$stmt){//Test if the query fails
						
							//die("Query error")."<br>". mysqli_error($stmt);
					  }	
					
					mysqli_stmt_close($stmt);//Close statment connection 
				}
			    redirect("allergys.php");
			
				}
				
			}
	  } 
		
 }

}

//Stops stop user inputing duplicate meal allergys on the meal allergy page
function allergy_exists($allergy_name){
	
	global $connection;
	
    $allergy_name = escape($allergy_name);

	$stmt3 = mysqli_prepare($connection,"SELECT allergry_id FROM allergy WHERE allergy_name = ? ");
	
	mysqli_stmt_bind_param($stmt3,'s', $allergy_name);
	mysqli_stmt_execute($stmt3);
	mysqli_stmt_store_result($stmt3);//Store result 
	
	$find_categories = mysqli_stmt_num_rows($stmt3);

	if ($find_categories > 0){
		
		return true;
			
	}else{

		return false;
	
		
	}
		mysqli_stmt_close($stmt3);//Close statment connection 
	
}   


///////////////////////Allergys end

		
////////////////////// Admin Index.php  functions

//Select all values from  database tables uses vales from the check_status query
function record_count($table){	
//Only admins can edit code
if(is_admin()){
	global $connection;	
	
    $stmt = mysqli_prepare($connection,"SELECT * FROM " . $table);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);//Store result 
    $result = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);//Close statment
	return $result;
}
}

//function used to find values to show in google charts on the admin index.php page - shows chart number 
function check_status($table, $colum, $status){
	
	global $connection;		
		
	$stmt = mysqli_prepare($connection,"SELECT * FROM $table WHERE $colum  = ? ");
	mysqli_stmt_bind_param($stmt,'s', $status);
	
	mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);//Store result 
	
	$find_status = mysqli_stmt_num_rows($stmt);

	if ($find_status < 1){//When no results are found return zero to the barchart
		
		mysqli_stmt_close($stmt);//Close statment
		
		$find_status = 0;
        return $find_status;
		
	}else{
		
		mysqli_stmt_close($stmt);//Close statment 
		return $find_status;
		
	}
	
}

////////////////////// Admin Index.php functions end

//**************************************************Sale order transactions****************************************************
function dispay_orders(){
//Show all orders on view_order pages

//Only admin users can edit code
if(is_admin()){

global $connection;	
$stmt = mysqli_prepare($connection, "SELECT order_id , order_date FROM orders ORDER BY order_id DESC");
mysqli_stmt_execute($stmt );

if($stmt->execute()){
						
//Bind these variable to the SQL results
$stmt->bind_result($order_id, $order_date);
  
  while($stmt->fetch()){

	$order_id  = escape($order_id);
	$order_date = escape($order_date);

//Heredoc Heredoc text behaves just like a double-quoted string, without the double quotes. This means that quotes in a heredoc do not need to be escaped, but the escape codes listed above can still be used		
$order  = <<<DELIMITER

 <tr>
   <td>{$order_id}</td>
   <td>{$order_date}</td>
 </tr>
 
DELIMITER;

echo $order;

}


if (!empty($_SESSION['drink_grand_total']) &&  !empty($_SESSION['meal_grand_total'])  ){
	
//Show grand total from drinks and meals 
$super_grand_total = ($_SESSION['drink_grand_total'] + $_SESSION['meal_grand_total']);
$super_grand_total  = as_pounds($super_grand_total);
	
echo "
<tr>
<td>
<b>Total earnings from orders is ".$super_grand_total."</b>
</td>
</tr>";	

}

}
}
}

//Convert to currency format
function as_pounds($value) {
	

  return '£' . number_format($value, 2);
}


//**************************************************/Sale order transactions drink products from order/**********************************

//Show drinks in an order - include on the admin.index.pgp page
function drinks_from_orders(){

//Only admin users can edit code
if(is_admin()){
$_SESSION['drink_grand_total'] = null;
unset($_SESSION['drink_grand_total']); 

$grand_total = 0;
$order[] = "";
$i =0;
	
global $connection;	

$stmt = mysqli_prepare($connection, "SELECT 
drinks.drink_id,
drinks.drink_name,
drinks.drink_description,
drinks.drink_category_id,
drinks.drink_price,
drinks.drink_image,
drinks.drink_portions,

drink_order_drinks.drink_order_drinks_id,
drink_order_drinks.order_id,
drink_order_drinks.drink_id,

drink_order_drinks.item_quantity,
drink_order_drinks.product_price_at_sale

FROM drink_order_drinks 
INNER JOIN drinks
ON drink_order_drinks.drink_id = drinks.drink_id ORDER BY drink_order_drinks.order_id DESC ");	

mysqli_stmt_execute($stmt);

if($stmt->execute()){
						
//Bind these variable to the SQL results
$stmt->bind_result(

$drink_id1, $drink_name, $drink_description, $drink_category_id, $drink_price, $drink_image,$drink_portions,
$drink_order_drinks_id, $order_id, $drink_id, $item_quantity, $order_drink_price);
  
  while($stmt->fetch()){

	$order_id  = escape($order_id);
	$drink_order_drinks_id = escape($drink_order_drinks_id);	
	$drink_id  = escape($drink_id);
	$drink_name = escape($drink_name);
	
    $item_quantity  = escape($item_quantity);
    $drink_price = escape($order_drink_price);
	$sub2 = as_pounds($drink_price * $item_quantity); 
	
	$drink_price2 = as_pounds($drink_price );		
	
	$sub = $item_quantity * $drink_price;	
	$grand_total += $sub; 
	$grand_total2 = as_pounds($grand_total);
	$_SESSION['drink_grand_total'] = ($grand_total);
	

//Heredoc Heredoc text behaves just like a double-quoted string, without the double quotes. This means that quotes in a heredoc do not need to be escaped, but the escape codes listed above can still be used		
$product  = <<<DELIMITER

    <tr>
		<td>{$order_id}<br>
	    <td>{$drink_name}<br>
		<td>{$item_quantity}</td>
		<td>{$drink_price2}</td>
		<td>{$sub2}</td>
	</tr>

DELIMITER;
// code is used to try to make the reports show the total for evey order - not working
$order[$i] = $order_id;
//echo $order[$i];
$i++;
echo $product;

}
echo "
<tr>
<td>
<b>Total earnings from drinks is ".$grand_total2."</b>
</td>
</tr>";	
		
}
}
}

//**************************************************/Sale order transactions food products from order/**********************************

//Show drinks in an order - include on the admin.index.pgp page
function food_from_orders(){

//Only admin users can edit code
if(is_admin()){
	
$_SESSION['meal_grand_total'] = null;
unset($_SESSION['meal_grand_total']); 

$grand_total = 0;
$order[] = "";
$i =0;
	
global $connection;	

$stmt = mysqli_prepare($connection, "SELECT 
        meal.meal_id,
        meal.meal_name,
		meal.meal_description,
		meal.meal_type_id,
		meal.meal_portions,
		meal.category_id,
		meal.meal_image,		
		meal_order_meals.meal_order_meals_id,
		meal_order_meals.order_id,
		meal_order_meals.meal_id,
		meal_order_meals.item_quantity,
		meal_order_meals.product_price_at_sale

FROM meal_order_meals

INNER JOIN meal

ON meal_order_meals.meal_id =  meal.meal_id ORDER BY meal_order_meals.order_id DESC");	

mysqli_stmt_execute($stmt);

if($stmt->execute()){
						
//Bind these variable to the SQL results
$stmt->bind_result(

$meal_id1, $meal_name, $meal_description, $meal_category_id, $meal_price, $meal_image,$meal_portions,
$meal_order_meals_id, $order_id, $meal_id, $item_quantity, $order_meal_price);
  
  while($stmt->fetch()){

	$order_id  = escape($order_id);
	$meal_order_meals_id = escape($meal_order_meals_id);	
	$meal_id  = escape($meal_id);
	$meal_name = escape($meal_name);
	
    $item_quantity  = escape($item_quantity);
	$meal_price = escape($meal_price);
	$meal_price2 = as_pounds($meal_price );		
	
	$sub = $item_quantity * $meal_price;	
	$grand_total += $sub; 
	$grand_total2 = as_pounds($grand_total);
	
	$_SESSION['meal_grand_total'] = ($grand_total);
	
    $sub2 = as_pounds($meal_price * $item_quantity); 
	      
//Heredoc Heredoc text behaves just like a double-quoted string, without the double quotes. This means that quotes in a heredoc do not need to be escaped, but the escape codes listed above can still be used		
$product  = <<<DELIMITER

    <tr>
		<td>{$order_id}<br>
	    <td>{$meal_name}<br>
		<td>{$item_quantity}</td>
		<td>{$meal_price2}</td>
		<td>{$sub2}</td>
	</tr>

DELIMITER;
// code is used to try to make the reports show the total for evey order - not working
$order[$i] = $order_id;
//echo $order[$i];
$i++;
echo $product;

}
echo "
<tr>
<td>
<b>Total earnings from meals is ".$grand_total2."</b>
</td>
</tr>";	
		
}
}

}
	
?>