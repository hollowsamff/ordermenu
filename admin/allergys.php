<?php //Page header include  page is used to show, delete and add  the drink categories from the database
include"includes/admin_header.php";

//If the function that tests if a user is admin sents back false
if(!is_admin()){

	header("Location: profile.php");//Only profile user can only acess the profile.php page 
}
	
?>
    <div id="wrapper">
	
	 <!-- Navigation -->
	 <?php include"includes/admin_navigation.php";//Page navigation include 
	 
	 	include("includes/delete_modal.php");
	 
	 ?>

			
<div id="page-wrapper">

	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="row">
		
			<div class="col-lg-12">
				<h1 class="page-header text-center">Meal Allergies</h1>
		
                               <!--drink categoy-->
						       <div class = "col-xs-6">
						       <table class = "table table-bordered table-hover">
					     	   <h3>Meal Allergies</h3>
							   <h5>You cannot delete allergys that are currently in use by a meal</h5>
							   <thead>
								<tr>
								<td><input  id = "select_All_Boxes" type ="checkbox"></td>
								
								<th>Name</th>
								<th>Description</th>
								<th>Edit</th>
								<th>Delete</th>
								<br>
								
							  <?php
							   $stmt = mysqli_prepare($connection,"SELECT * FROM allergy ORDER BY allergy_name ASC");

								if($stmt->execute()){
									
								  //Bind these variable to the SQL results
								  $stmt->bind_result($allergy_id , $allergy_title, $allergy_description);
								  //Fetch will return all fow, so while will loop until reaches the end
								  while($stmt->fetch()){
									  
									echo"<tr>";
									?>
									<td><input class = 'check_Boxes' type ='checkbox'  name='check_box_array[]' value ='<?php echo $comment_id;?>'></td>
									<?php //Stores the ids of the selected boxes in an array
									//echo "<td>{$allergy_id}</td>";
									echo "<td>{$allergy_title}</td>";
									echo "<td>{$allergy_description}</td>";
								
									echo "<td><a class='btn btn-info'href='allergys.php?edit={$allergy_id}'> Edit </a></td>";//Edit button
									echo"<td><a class=' btn btn-danger delete_link' rel='$allergy_id' href='javascript:void(0)'>Delete</a></td>";
								
									//When the link is pressed assign the value in allergy_id to the parameter delete(will be used as index value in delete query)Then send the delete parameter to the delete query
									
									echo"</tr>";

									}
								}	
								?>
										   	
								</tbody>
							    </table>
						        </div>
								<div class = "col-xs-6">
								
								<br><br><br><br>
								
								
									<!-- Add category form-->
									<form action= "" method = "post">
									<h3>Add Allergy</h3>
										<div class = "form-group">
										<label for= "title">Allergy Name</label>
										<input type="text" name="allergy_name" id="allergy_name" class="form-control" placeholder="Enter allergy name" autocomplete="on" value="<?php echo isset($allergy_name_original ) ? $allergy_name_original  : '' ;?>" >
										<h4 class="warning_red"><?php echo isset($error['$allergy_name_original']) ? $error['$allergy_name_original '] : '' ?></h4>
										</div>
										
								
										<div class = "form-group">
										<label for= "title">Allergy Description</label>
										<input type="text" name="allergy_description" id="allergy_description" class="form-control" placeholder="Enter allergy description" autocomplete="on" value="" >
										</div>	
																					
										
										<div class = "form-group">
										<input class = "btn btn-primary" type = "submit" name = "submit" value="Add meal allergy">
										</div>
	
									</form>
							        <?php insert_allergy();//Insert allergy function ?>

									 <?php
									//Only logged in Admin user can edit code
									if(is_admin()){ 
									//Update query  - used with insert category function
									 if(isset($_GET["edit"])){//Uses GET data from Current Categories edit button
									
									  include"includes/update_allergy_categories.php";//update_categories include
									 
									 }
									}
									?>
									
									</div><!--end col-xs-6 for current categories display-->
				
				
								   <?php //Delete the drink categories from database  drink categories table
								   if(isset($_GET['delete'])){//If user has sent the delete parameter useing the delete buttons
								   	
										//Only logged in Admin user can edit code
										if(is_admin()){
											 
											 $the_allergy_id = escape($_GET['delete']);
											 
											 $stmt = mysqli_prepare($connection,"Delete FROM allergy WHERE allergry_id = ?");
											 //Delete the categories with the same id as the delete button which was pressed
											 mysqli_stmt_bind_param($stmt,'i', $the_allergy_id);
											  
											 mysqli_stmt_execute($stmt);
							
											 mysqli_stmt_close($stmt);//Close statment
											 
											 header("Location: allergys.php");//Refresh the page - the page needs to be refreshed for the delete to work
												
											}	
																				 
									    }
				
							?>
					
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>	
		
<?php include"includes/admin_footer.php";//Page footer include ?>

<script> //Code used to make the delete function message box delete a post

$(document).ready(function(){
   	
		$(".delete_link").on('click',function(){
		
		var id = $(this).attr("rel");
		//alert(id);
		var delete_url = "allergys.php?delete=" +id; //Used to run the delete query for the drink category	
		//alert(delete_url);	
		
		//Input the result in the delete model message
		$(".modal_delete_link").attr("href",delete_url);
		
		$('#myModal').modal('show')	;
	
	 });
	 


});//End of document.ready
</script>