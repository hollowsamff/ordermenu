<script> 

$('document').ready(function(){
	//Used to show the tool tip on the TAGS content box - explains that the user needs to separate tags with comas
	$('[data-toggle="tooltip"]').tooltip(); 
});
</script>


<?php
//Page used to edit the posts from the posts.php page

if(isset($_GET['p_id'])){
	
		$get_post_id = escape($_GET['p_id']);//Put sent value in varable
	}	
	     //Find the posts with the same id that was sent from the posts.php page
		 $stmt = mysqli_prepare($connection,"SELECT post_id, post_category_id, post_title, post_comment_count,  post_author, post_date,	 
		 post_image, post_content, post_tags, post_status FROM posts WHERE post_id = ?");
		 mysqli_stmt_bind_param($stmt,"i", $get_post_id);
		 $stmt->execute();
         $stmt->bind_result($post_id, $post_category_id, $post_title, $post_comment_count,  $post_author, $post_date,	 
		 $post_image, $post_content, $post_tags, $post_status);
	
		//Show all the fields from the post	database on the page
	   while($stmt->fetch()){
			//Varables = the the values from the database
			$post_id = escape($post_id) ;
			$post_author = escape($post_author);
			$post_title = escape($post_title);
			$post_category_id = escape($post_category_id);
			$post_status = escape($post_status);
			$post_image = escape($post_image);
			$post_tags= escape($post_tags);
			$post_comment_count = escape($post_comment_count);
			$post_date = escape($post_date);
		    $post_content = $post_content;
			//Add line breaks to content
            //$post_content   = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"<br>",$post_content  );	
		    //$post_content  = mysqli_real_escape_string($connection,$post_content  );


	}
		 
		//Query to update the posts - values sent from Edit Posts form
		if(isset($_POST['update_post'])){
			
				//Put the  sent values in varables
				$post_author = escape( $_POST["user"] );
				$post_title = escape($_POST["title"] );
				$post_tags = escape($_POST["post_tags"] );
				$post_status = escape($_POST['post_status']);
				$post_category_id = escape($_POST["post_categories"] );
				$post_content = $_POST["post_content"] ;
					
			    //Associative arrays replace the index with a lable - this is called a key
			    $error = ["image" => ""];//e.g. first_name replaced 0 - =>  is used to assign a value to a associative array

				//Used to test if the image is fake 
				$post_image_temp = $_FILES['image']['tmp_name'];
				
				if (!empty($post_image_temp)) {

					list($width, $height) = getimagesize($post_image_temp);
					
					if ($width < 1 || $height <1 ){
						
						 $error['image'] = 'You can not upload fake images on this website.';
							 
					}else{//When the image is real
						
					   //Function used to save the image - move from temp location to websites image folder
					   $post_image = $_FILES['image']['name'];
					   move_uploaded_file ($post_image_temp, "../images/$post_image");
	   
					}
				 }
			    //Used to test for and show error message
				foreach ($error  as $key => $value) {  
					
					if (empty($value)){
						
						unset($error[$key]);//Remove old values out of empty fields
					
					  }
					}
					
                  if(empty($error)){ //When no errors are found edit user
				  
			         if(empty($post_image)){//If user does not change image keep current image
							
						$stmt2 = mysqli_prepare($connection,"SELECT post_image FROM posts WHERE post_id = ?");
						mysqli_stmt_bind_param($stmt2,"i", $post_id );
						mysqli_stmt_execute($stmt2);
						
						$stmt2->bind_result($post_image);

						 while($stmt2->fetch()){//Loop though the database search and put the found image in a variable
							
						  $post_image = $post_image ;

					     }
					  mysqli_stmt_close($stmt2);//Close statment connection   
					}
	
					//Add line breaks to content;	
					$post_content  = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",	$post_content);
					$post_content  = mysqli_real_escape_string($connection,$post_content);
					$post_content  = stripslashes($post_content);
					 
					$post_date = date('Y-m-d H:i:s');
			
				   $stmt = mysqli_prepare($connection,"UPDATE posts SET post_title = ? , post_category_id = ?,  
				   post_author = ? , post_status = ?, post_tags = ?, post_content = ?, post_image = ?, post_date = ? 
				   WHERE post_id = ?");
				   
				   //Update the categories with the same id as the update button which was pressed
				   mysqli_stmt_bind_param($stmt,'sissssssi',$post_title , $post_category_id,  $post_author, $post_status, $post_tags,
				   $post_content, $post_image, $post_date, $get_post_id);

				   mysqli_stmt_execute($stmt);

				  if(!$stmt){//Test if the query fails//die("Query error test")."<br>". mysqli_error($stmt);}	  
				  }
				  mysqli_stmt_close($stmt);//Close statment
					
				  echo "<h4>Post Updated. <a href='../post.php?p_id={$get_post_id}'> View Post</a> or
				  <a href = 'posts.php'>Edit More Posts </a>
				  </h4>";//Load the added post
					
				  //header("Location:posts.php?source=edit_posts&p_id=452"); 
			
	}
}
?>
<div class="container-fluid">

  <div class="col-lg-12">
   
		 <h2>Edit Post</h2>

		<form action = "" method="post" enctype="multipart/form-data"><!-- --> 
		
		<div class = "form-group">
		
		<label for= "title">Post Title</label>
		<input value="<?php echo $post_title;?>" type = "text" class="form-control" name = "title">
		</div>
		
		<div class = "form-group">
		<label for= "post_categories">Post Category</label>
		<br>
		<select name="post_categories" id="" type = "text" class="form-control">

		<?php
		 //Find all the categories from database categories table where the cat_id is equal to the send value
		 $stmt = mysqli_prepare($connection,"SELECT *  FROM categories");
		
		 if($stmt->execute()){
			
		  //Bind these variable to the SQL results
		  $stmt->bind_result($cat_id , $cat_title);
		  
			while($stmt->fetch()){
		
			$cat_id = escape($cat_id );
			$cat_title = escape($cat_title);
			if($post_category_id == $cat_id){
				
			echo "<option selected value='$cat_id'>{$cat_title}</option>";
			
			}else{
			
			echo "<option value='$cat_id'>{$cat_title}</option>";
			
			}

			}
		 }
		
		?>
		</select>
		</div>
		
		
	  <div class = "form-group">
		<label for= "author">Post Author</label>
		<select name = "user" id=""  class="form-control" >
		<?php //echo "<option value='{$post_author}'>{$post_author}</option>";?>
		<?php
		 //Find all the users from database
		 $stmt = mysqli_prepare($connection,"SELECT user_id, user_name FROM users");
		 $stmt->bind_result($user_id , $user_name);
		 if($stmt->execute()){
		
			while($stmt->fetch()){
		
			$user_id = escape($user_id);
			$user_name= escape($user_name);
			if($post_author == $user_name){
				
			echo "<option selected value='$user_name'>{$user_name}</option>";
			  
			} else {

			  echo "<option value='$user_name'>{$user_name}</option>";
			  
			  }
			
			}
		 }

		
		?>
		</select>
		</div>
		
		
		<div class = "form-group">
		<label for= "post_status">Post Status</label>
		<select type = "text" class="form-control" name = "post_status">
		
		<option value= "<?php echo $post_status?>"> <?php echo $post_status ?> </option>
			
		<?php
		
			if ($post_status == "published"){
			
			echo "<option value='draft'>draft</option>";

		}else{
			
			echo "<option value='published'>published</option>";
		}

		?>
		</select>
		</div>

		<div class = "form-group">
		<img width='100' src ='../images/<?php echo $post_image; ?>' alt='postimage'>
		</div>
		
		<div class = "form-group">
		<label for= "post_image">Post Image</label>
		<input  type = "file" name = "image">
		<h4 class="warning_red"><?php echo isset($error['image']) ? $error['image'] : '' ?></h4>
		</div>
			
		<!--Tags not in use currently-->	
		<div class = "form-group">
		<input value="<?php echo $post_tags;?>"  type = "hidden" class="form-control" name = "post_tags"
		href="#" data-toggle="tooltip" title="Separate tags with comas">
		</div>

		<div class = "form-group">
		<label for= "post_content">Post Content</label>
		<textarea class="form-control" name = "post_content" id="" cols="30" rows="10">
		<?php
		//Remove spacing charecters from database string
		//echo $post_content2 =  str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n","&nbsp;"),"",$post_content);	
        echo $post_content;
		?>
		</textarea>             

		<br>
		<div class = "form-group">
		<input class = "btn btn-primary" type = "submit" name = "update_post" value="Edit Post">
		</div> 						

	</form>

    </div>
 <!-- /.container-fluid -->
 </div>		