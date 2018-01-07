<?php
//Page used to edit the users from the users.php page

if(isset($_GET['user_id'])){
	
		$users_id = escape($_GET['user_id']);//Put sent value in varable

		//Find the posts with the same id that was sent from the posts.php page
		 $stmt = mysqli_prepare($connection,"SELECT user_id, user_name, user_password, user_first_name,  user_last_name, user_email,	 
		 user_image, user_DOB FROM users WHERE user_id = ?");
		 mysqli_stmt_bind_param($stmt,"i", $users_id );
		 $stmt->execute();
         $stmt->bind_result($user_id, $user_name, $user_password, $user_first_name,  $user_last_name, $user_email,	 
		 $user_image, $user_DOB);
		
		
		//Show all the fields from the user database on the page
		   while($stmt->fetch()){
			//Varables = the the values from the database
			$user_id = $user_id;
			$user_name = $user_name ;
			$user_password = $user_password ;
			$user_first_name = $user_first_name ;
			$user_last_name = $user_last_name;
			$user_email = $user_email;
			$user_image = $user_image;
			$user_DOB = $user_DOB;
			
	}
	     		 		 
		//Query to update the users - values sent from Edit users form
		if(isset($_POST['update_users'])){
			
				//Put the  sent values in varables
				//$user_name = mysqli_real_escape_string($connection, $_POST["user_name"] );
				$user_first_name = escape($_POST["user_first_name"] );
				$user_last_name = escape($_POST["user_last_name"]);
				$user_DOB = escape($_POST["user_DOB"] );
			  
				//Associative arrays replace the index with a lable - this is called a key
			    $error = [ "email" => "","image" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array

				//Used to test if the image is fake 
				$user_image_temp = $_FILES['image']['tmp_name'];
				
				if (!empty($user_image_temp)) {

					list($width, $height) = getimagesize($user_image_temp);
					
					if ($width < 1 || $height <1 ){
						
						 $error['image'] = 'You can not upload fake images on this website.';
							 
					}else{//When the image is real
						
					   //Function used to save the image - move from temp location to websites image folder
					   $user_image = $_FILES['image']['name'];
					   move_uploaded_file ($user_image_temp, "../images/$user_image");
	   
					}
				 }
			
			
			    //Used to compare the original email and the user input email
			    $user2_email = $user_email;
				$user_email = escape($_POST["user_email"] );
				//When email is the same do nothing 
				if ($user_email == $user2_email){

				}else{//Test if the email is being used by other users

					  if (user_email_exists($user_email)){
			
	 	                   $error['email'] = 'Email already exists, please pick another one.';
	                    }
				}
	
	            // Used to test for and show error message
				foreach ($error  as $key => $value) {  
					
					if (empty($value)){
						
						unset($error[$key]);//Remove old values out of empty fields
					
					  }
					}
					
                  if(empty($error)){ //When no errors are found edit user
					
					  $user_DOB = date('Y-m-d',strtotime(escape($user_DOB)));//Convert date to database format
				
					if(empty($user_image)){//If user does not change image keep current image
											
						$stmt2 = mysqli_prepare($connection,"SELECT user_image FROM users WHERE user_id = ?");
						mysqli_stmt_bind_param($stmt2,"i", $user_id );
						mysqli_stmt_execute($stmt2);
						
						$stmt2->bind_result($user_image);

						 while($stmt2->fetch()){//Loop though the database search and put the found image in a variable
							
							$user_image =  $user_image ;
					      }
					    mysqli_stmt_close($stmt2);//Close statment connection 
						}
					
					
						if($_POST["user_password"]){
							
						$user_password = escape($_POST["user_password"] );	
						//Use blowfish to hash the password - first value is password variable , second is encryption type and third is number of time hash will be run
						$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
							
						}else{//When user does not input password keep current password
						
						$user_password = $user_password;
								
						}

						$stmt = mysqli_prepare($connection,"UPDATE users SET user_email  = ? , user_password = ?,  
						user_first_name = ? , user_last_name = ?, user_DOB = ? , user_image  = ? WHERE user_id = ?");
						//Query to update database users
						mysqli_stmt_bind_param($stmt,'ssssssi',$user_email, $user_password,  $user_first_name, $user_last_name, $user_DOB,
						 $user_image, $user_id);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);//Close statment
						
				        echo " <h4> User Updated: " . " " . "<a href='users.php'>View Users</a></h4>";
                 }//End of 

		}//End isset($_POST['update_users'])
		
} //End isset($_GET['user_id'
else{ //When user is not logged in sent them to index.php

header("Location:../index.php");	

}

?>
<div class="container-fluid">

    <div class="col-lg-12">

		<h2>Edit User</h2>

		<form action = "" method="post" enctype="multipart/form-data"><!-- --> 
		
		<div class = "form-group">
		<label for= "title">Username</label>
		<input value="<?php echo $user_name ?> " type = "text" class="form-control" name = "user_name" readonly="value">
		</div>
		
		<div class = "form-group">
		<label for= "title">Firstname</label>
		<input value="<?php echo $user_first_name ?>" type = "text" class="form-control" name = "user_first_name">
		</div>
		
		<div class = "form-group">
		<label for= "title">Lastname</label>
		<input value="<?php echo $user_last_name ?>" type = "text" class="form-control" name = "user_last_name">
		</div>
	
		<div class = "form-group">
		<label for= "title">DOB</label>
		<input type="text" value="<?php echo $user_DOB = date('d-m-Y',strtotime(escape($user_DOB)));//Convert date to uk format ?>" 
		class="form-control"  name = "user_DOB" placeholder="DD-MM-YYYY"
		required pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" title="Enter a date in this formart DD-MM-YYYY"/>
		</div>
		
		<div class = "form-group">
		<label for= "title">Email</label>
		<input value="<?php echo $user_email ?>" type = "text" class="form-control" name = "user_email">
		<h4 class="warning_red"><?php echo isset($error['email']) ? $error['email'] : '' ?></h4>
		</div>
		
		<div class = "form-group">
		<label for= "title">Password</label>
		<input  type = "text" class="form-control" name = "user_password">
		</div>
			
	   <div class = "form-group">
		<img width='100' src ='../images/<?php echo $user_image; ?>' alt='userimage'>
		</div>
		
		<div class = "form-group">
		<label for= "post_image">Post Image</label>
		<input  type = "file" name = "image" >
		<h4 class="warning_red"><?php echo isset($error['image']) ? $error['image'] : '' ?></h4>
		</div>

		<br>
		<div class = "form-group">
		<input class = "btn btn-primary" type = "submit" name = "update_users" value="Edit User">
		</div> 						

		</form>
	   
    </div>
 <!-- /.container-fluid -->
 </div>	
		