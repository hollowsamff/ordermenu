<?php 
//Page used to create accounts for the website
//Connection to database include
include"includes/db.php";
//Page header include
include"includes/header.php";
//Page navigation bar include
include"includes/navigation.php";


// Used to sent messages
//if(isset($_POST['regester'])){
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
		$email = escape($_POST['email']);
		$username = escape($_POST['username']);
        $password = escape($_POST['password']);
        
		//Associative arrays replace the index with a lable - this is called a key
		$error = ["username" => "", "email" => "", "password" => "" ];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array
				
		if (strlen($username)< 1){
				
		$error['username'] = 'Username needs too have at least 1 value';
		"<br>";
		}
	
		 if($username == '' ){
	
	       $error['username'] = 'Username cannot be empty.';	

	    }		 
	
	   if($password == ''){
	
	       $error['password'] = 'Password cannot be empty.';
	

	    }		
		
		 if($email ==''){
	
	     $error['email'] = 'Email cannot be empty.';

	     }		
				
		
	   if (user_name_exists($username)){
		
		 $error['username'] = 'Username already exists, please pick another one.';

		}	
		 
	
	  if (user_email_exists($email)){
			
	 	 $error['email'] = 'Email already exists, please pick another one.';
				
	   }
		  		 
							 
	foreach ($error  as $key => $value) { // Used to test for and show error messages 
			
			if (empty($value)){
				
				unset($error[$key]);//Remove old values out of empty fields
			
		      }
		    }
			
		if(empty($error)){ //When no errors are found 
		  
	            echo $message = "<h2 class='text-center'>Your Registration Has Been Submited</h2>";
				regester_user($username,$email,$password) ;// Load function to regester user 
                $username ='';
				$password ='';
				$email ='';  
				//login_user($username,$password);//Load function to login user
		}		 		
	
}



?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    <!-- Page Content <h6 class = "text-center"><?php//echo $message ?> </h6> -->
    <!-- Page Content -->

<div class="container-fluid">
    
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="form-wrap">
                <h1 class='text-center'>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

						 <div class="form-group">
						 <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
						 <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username) ? $username : '' ;?>" >
						 <h4 class="warning_red"><?php echo isset($error['username']) ? $error['username'] : '' ?></h4>
						 </div>

						 <div class="form-group">
                         <label for="email"><span class="glyphicon glyphicon-envelope"></span> Email</label>
                         <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address" autocomplete="on" value="<?php echo isset($email) ? $email : '' ;?>" >
                         <h4 class="warning_red"><?php echo isset($error['email']) ? $error['email'] : '' ?></h4>
                         </div>

						<div class="form-group">
						<label for="password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
						<input type="password" name="password" id="key" class="form-control" placeholder="Password">
						<h4 class="warning_red"><?php echo isset($error['password']) ? $error['password'] : '' ?></h4>
						</div>
                
                        <input type="submit" name="regester" id="btn-login" class="btn btn-custom btn-lg btn-block btn-primary" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>

<?php include "includes/footer.php";?>
