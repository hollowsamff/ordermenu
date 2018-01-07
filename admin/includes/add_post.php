<script> 

$('document').ready(function(){
	//Used to show the tool tip on the TAGS content box - explains that the user needs to separate tags with comas
	$('[data-toggle="tooltip"]').tooltip(); 
	  
	var sendForm= true;
	//If the title field is blank the user can not submit the form
	$('#submit').click(function(){
		
		var str = $('#title').val();
		if (str == ""){
		
		event.preventDefault();	
		//Show error message
		$('#error_message').css('display','inline');
			
		}

	});

});
</script>



<?php
//Stops error message echo being undefined when page loads
$POST_content = "";

//Page is used to add a post to database - uses the http://localhost/projects/cms/admin/posts.php?source=add_post page
if(isset($_POST["create_post"])){

       $POST_title = escape($_POST['title']);
	   $POST_tags = escape($_POST['post_tags']);
	   $POST_content = $_POST["post_content"] ;
	   $POST_status = escape($_POST['post_status']);
	   
		if($POST_title != ''){
	
			//Associative arrays replace the index with a lable - this is called a key
			$error = ["image" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array
			
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
			
			// Used to test for and show error message
			foreach ($error  as $key => $value) {  
				
				if (empty($value)){
					
					unset($error[$key]);//Remove old values out of empty fields
				
				  }
				}
				
		
		 if(empty($error)){ //When no errors are found edit user
	
			$POST_category_id = escape($_POST['post_categories']);
			$post_author = escape($_POST['user']);
			$POST_content = escape($_POST['post_content']);
			//Add line breaks to content
            $POST_content  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",$POST_content );	
		    $POST_content  = mysqli_real_escape_string($connection,$POST_content);
			$POST_content  = stripslashes($POST_content);
			
			
			$POST_image = $_FILES['image']['name'];
			$POST_image_temp = $_FILES['image']['tmp_name'];
			$post_comment_count = 0;
			
			//Function used to save the image - move from temp location to websites image folder
			move_uploaded_file ($POST_image_temp, "../images/$POST_image");
			
			$POST_date = date('Y-m-d H:i:s');
					
			//Query to input values into database
			$stmt = mysqli_prepare($connection, "INSERT INTO posts(post_category_id, post_title,  post_author, post_date, post_image, post_content, post_tags, post_status,post_comment_count ) 
			VALUES (?, ? , ? ,?,?, ? , ? ,?,?)" );
			mysqli_stmt_bind_param($stmt,'ssssssssi',$POST_category_id, $POST_title, $post_author, $POST_date, $POST_image, $POST_content, $POST_tags, $POST_status,$post_comment_count);

			mysqli_stmt_execute($stmt);
				   
			if(!$stmt){die("Query error");  }
				
			//Find id of last created post
			$get_post_id = mysqli_insert_id($connection);
			$POST_title = null;
			$POST_tags = null;
			$POST_content = null;
			
			
			$POST_category_id = null;
			//$post_author = null;
			$POST_status = null;

			echo "<h4>Post Created. 
			<a href='../post.php?p_id={$get_post_id}'> View Post</a> or
			<a href = 'posts.php'>Edit More Posts </a>
			</h4>";//Load the created post
		 }			   	
     } 
  }

?>

<div class="container-fluid">

  <div class="col-lg-12">

	<h2>Add Post</h2>

	<form action = "" method="post" enctype="multipart/form-data"><!-- --> 

		<div class = "form-group">
		<label for= "title">Post Title</label>
		<input type = "text" class="form-control" name = "title"  id = "title" 
		placeholder="Enter Title" autocomplete="on" value="<?php echo isset($POST_title) ? $POST_title : '' ;?>">
		<h4 class="warning_red"><?php echo isset($error['title']) ? $error['title'] : '' ?></h4>
	    </div>
		
		<style>#error_message{color:red;display:none}</style>
		<h4 id="error_message" class="error">Post Title cannot be empty.</h4>
		
		<div class = "form-group">
		<label for= "post_categories">Post Category</label>
		<select name="post_categories" id=""  class="form-control" >
		<?php
		
		 //Find all the categories from database categories table where the cat_id is equal to the send value
		 $stmt = mysqli_prepare($connection,"SELECT *  FROM categories");
		 $stmt->bind_result($cat_id , $cat_title);
		 if($stmt->execute()){
			
		  //Bind these variable to the SQL results
		  $stmt->bind_result($cat_id , $cat_title);
		  
			while($stmt->fetch()){
		
			$cat_id = escape($cat_id );
			$cat_title = escape($cat_title);
			echo "<option value='$cat_id'>{$cat_title}</option>";

			}
		 }
		  mysqli_stmt_close($stmt);//Close statment connection 
		?>
		</select>
		</div>
		
		<div class = "form-group">
		<label for= "user">Post Author</label>
		<select name = "user" id=""  class="form-control" >
		
		<?php
		//Find all the users from database
		 $stmt = mysqli_prepare($connection,"SELECT user_id, user_name FROM users");
		 $stmt->bind_result($user_id , $user_name);

		 if($stmt->execute()){
		
			while($stmt->fetch()){
		
			$user_id = escape($user_id);
			$user_name= escape($user_name);
			echo "<option value='{$user_name}'>{$user_name}</option>";
			}
		 }
		?>

		</select>
		</div>

		<div class = "form-group">
		<label for= "post_status">Post Status</label>
		<select  type = "text" class="form-control" name = "post_status">
		<?php
		  //When the form has not been sent show these values
		  if (empty($POST_status)){

			?>
			 <option value="draft">Draft</option>
			 <option value="published">Published</option>
			<?php

		  }else{//If the form is not sent show the post status that was not selected in the select
		  //Convert first letter to upper case - improve readability and consistency since all the other input field start with a capital letter 
		  $POST_status_upper = ucfirst(strtolower($POST_status));
		  
		  echo "<option value='$POST_status'>{$POST_status_upper}</option>";
			
		  if ($POST_status_upper == "Published"){
			
		  echo "<option value='draft'>Draft</option>";

		  }else{
			
			echo "<option value='published'>Published</option>";
			
		   }
		  }
		?>
		</select>
		</div>
		
		<div class = "form-group">
		<label for= "post_image">Post Image</label>
		<input type = "file" name = "image" alt="postimage">
		<h4 class="warning_red"><?php echo isset($error['image']) ? $error['image'] : '' ?></h4>
		</div>

		<!--Tags not in use currently-->	
		<div class = "form-group">
		<input  value="<?php echo isset($POST_tags) ? $POST_tags : '' ;?>" 
		type = "hidden" class="form-control" name = "post_tags" id = "post_tags" 
		href="#" data-toggle="tooltip" title="Separate tags with comas">
		</div>


		<div class = "form-group">
		<label for= "post_content">Post Content</label>
		<textarea = "text" class="form-control" name = "post_content" id="post_content" cols="3" rows="10">
	    <?php
        echo $POST_content ;
		?>
		</textarea>             
        </div>
   
		<br>
		<div class = "form-group">
		<input class = "btn btn-primary" type = "submit" name = "create_post" id="submit"   value="Add Post">
		</div> 						
	   </form>
	   
     </div>
 <!-- /.container-fluid -->
 </div>		
	