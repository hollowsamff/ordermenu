<?php 
//Login page for the menu content managment system. All the text on the page is generated from a database that the user can change using the websites content managment system
//Connection to database include
include"includes/dbnotautorised.php";
//Page header include
include"includes/header.php";
//Page navigation bar include
include"includes/navigation.php";
?>

<?php 
//Find the content that will populate the page from the database
 $stmt = mysqli_prepare($connection,"SELECT indivigual_page_content_id, indivigual_page_content_text, indivigual_page_content_image_one, indivigual_page_content_image_two
  FROM indivigual_page_content WHERE indivigual_page_content_ID = 20");
  if($stmt-> execute()){

      $stmt->bind_result($id, $text,$user_image, $user_image2);
  
	  while ($stmt->fetch()){

	  }
  }
//The values from the indivigual_page_content  field is stored in $text 
$myString = $text;
$split_string = explode('~', $myString);//The differnt section of the page are seperated by ~ 
//An  explode is used to this split the text in to an array and the arrays values are  displayed on the page		
?>

    <div class="container-fluid">
	
    <div class="row">
        <div class="col-md-8">
		

		    <!--Show page heading-->
            <h1 style="color:#3CB371" class='text-center'><?php echo $split_string[0];?></h1>
			 <!--Show page sub heading-->
             <h3  class='text-center'style="margin-top:-5px;"><i><?php echo $split_string[1];?></i></h3>    
             <p>
			
			 <!--Show page paragraph one-->
			 <?php echo $split_string[2];?>
			 </p>

			 
			 <div class ="col-md-12">
       
           
			<!--<img class="img-responsive" src="images///<?Php //echo $post_image;?>" alt=""><!-- $post_image contains a referance(the name) of the image from the database -->
			<img  width='100%' height='240'  src ='images/<?php echo $user_image ?>' alt="companybuilding"><!-- $post_image contains a referance(the name) of the image from the database -->
			<br><br>
			
            </div>
			 <!--Show page bullet point list one heading-->
			 <h4><b> <?php echo $split_string[3];?></b></h4>
			 
			 <!--Show page bullet list one indivigual bullets-->
			 <ul class="listStyle">
			 <?php 
			 //The bullet point values are seperated useing a full stops in the website database
			 $bullet_list_two = $split_string[4];
             $bullet_list_two = explode('.', $bullet_list_two);//Store the differnt bullet point in an array
             $bullet_list_two_count = count($bullet_list_two);//Count the number of bullet points in the list
			
		     //Print all the bullet points from the array in a list useing a loop - the first value in the array is a full stops so the loop starts at one
			 for($x = 1; $x < $bullet_list_two_count; $x++){//X is used to show all the items in the array when the loop runs
			
				echo"<li><span>".$bullet_list_two[$x]."</span></li>";
			 }

			 ?>
			 </ul>
		 
			 <!--Show page bullet point list two heading-->
			 <h4><b> <?php echo $split_string[5];?></b></h4>
			 
			 <!--Show page bullet list two indivigual bullets-->
			 <ul class="listStyle">
			 <?php 
			 //The bullet point values are seperated useing a full stops in the website database
			 $bullet_list_two = $split_string[6];
             $bullet_list_two = explode('.', $bullet_list_two);//Store the differnt bullet point in an array
             $bullet_list_two_count = count($bullet_list_two);//Count the number of bullet points in the list
			
		     //Print all the bullet points from the array in a list useing a loop - the first value in the array is a full stops so the loop starts at one
			 for($x = 1; $x < $bullet_list_two_count; $x++){//X is used to show all the items in the array when the loop runs
			
				echo"<li><span>".$bullet_list_two[$x]."</span></li>";
			 }

			 ?>
			 </ul>
		
			  <!--Show page paragraph two-->
			 <?php echo $split_string[7];?>
        </div>
		
		    <div class ="col-md-2">
            <!-- Blog Sidebar Widgets Column include-->
            <?php include"includes/sidebar.php" ?>
			<br>
			<!--<img class="img-responsive" src="images///<?Php //echo $post_image;?>" alt=""><!-- $post_image contains a referance(the name) of the image from the database -->
		
		<!-- $post_image contains a referance(the name) of the image from the database -->
			
			
    </div>
	<br><br>
</div>
	

<?php include "includes/footer.php";?>
