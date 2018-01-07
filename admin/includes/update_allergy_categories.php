	<!-- Update allergy category POST data form-->
	<form action= "" method = "post">
		<div class = "form-group">
		<hr>
		<h3>Update Allergy</h3>

	<?php
		   //Used to show text box which is used to edit the categories from database categories table - activate when edit button is pressed
		   if(isset($_GET['edit'])){
			   
				$allergy_id = escape($_GET['edit']);//Value send from the Edit button
			   
				 //Find all the categories from database categories table where the allergy_id is equal to the send value
				 $stmt = mysqli_prepare($connection,"SELECT allergry_id, allergy_name, allergy_description FROM  allergy WHERE allergry_id = ?");
				 mysqli_stmt_bind_param($stmt,'i', $allergy_id );
				 mysqli_stmt_execute($stmt);
				 $stmt->bind_result($allergry_id, $allergy_name, $allergy_description);

				 //Show all the categories from database categories table 
				 while($stmt->fetch()){
					 
					$allergy_id = escape($allergy_id);
					$allergy_name_original = escape($allergy_name);
					$allergy_description = escape($allergy_description);

					
					
   ?>

				<div class = "form-group">
				<label for= "title">Allergy Name</label>
				<input type="text" name="allergy_name" id="allergy_name" class="form-control" placeholder="Enter allergy name" autocomplete="on" value="<?php echo isset($allergy_name_original ) ? $allergy_name_original  : '' ;?>" >
				<h4 class="warning_red"><?php echo isset($error['$allergy_name_original']) ? $error['$allergy_name_original '] : '' ?></h4>
				</div>
				
		
				<div class = "form-group">
				<label for= "title">Allergy Description</label>
				<input type="text" name="allergy_description" id="allergy_description" class="form-control" placeholder="Enter allergy description" autocomplete="on" value="<?php echo isset($allergy_description) ? $allergy_description : '' ;?>" >
				</div>	

		
<?php } }
			  mysqli_stmt_close($stmt);//Close statment
			
?>
   
		 <?php
		 
			//Code runs after the Current Categories table update button is pressed and the Update category show edit box code runs
			//Update query update_category POST is sent from Update category POST data form
			if(isset($_POST['update_category'])){//If user has sent a value useing the Update category form run the code
			 
	
				   $allergy_name =  escape($_POST["allergy_name"]);
				   $allergy_description = escape($_POST["allergy_description"]);
				   $allergy_description = stripslashes($allergy_description);
			
					if( $allergy_name == "" || empty( $allergy_name) || $allergy_description == "" || empty( $allergy_description)){//Test if the value is blank
			  
						echo"<h4 class='warning_red'>Fields cannot be empty!</h4>";
						
					}else{//Insert value into database categories table
						
							//Keep same value if user makes no changes - use function to test if the category exists
							if ( $allergy_name  != $allergy_name_original  and  allergy_exists($allergy_name ) !== false){
								
								echo"<h4 class='warning_red'>Allergy already exists!</h4>";

							}else{//Update allergy
						
						
								if(is_admin()){//Only logged in Admin users can edit code
						
										   $stmt = mysqli_prepare($connection, "UPDATE  allergy SET allergy_name = ?, allergy_description = ?
										   WHERE allergry_id = ?");
										   
										   mysqli_stmt_bind_param($stmt,'ssi',$allergy_name, $allergy_description,  $allergry_id);

										   mysqli_stmt_execute($stmt);
										   
										   if(!$stmt){ // die("Query error")."<br>". mysqli_error($stmt); 
										   }
											//Remove values so allergys can input another allergy without reloding the page
										   $allergy_name =  null;
										   $allergy_description = null;
											 
										   mysqli_stmt_close($stmt);//Close statment connection
								}
					
						}//End duplicate test 
				
				
				   }
					  
					    redirect("allergys.php");//Reload allergy page

			}		
		
			?>

			</div>
			<div class = "form-group">
			<input class = "btn btn-primary" type = "submit" name = "update_category" value="Update allergy">
			</div>
			
		</form><!-- Update category POST data form end -->