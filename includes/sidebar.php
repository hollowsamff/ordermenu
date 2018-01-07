			
				<?php //Hide the login form after users login
				
				if(isset($_SESSION['user_role'])): ?>
				<div class="well">
				<h4>Logged in as <?php echo $_SESSION['user_name']  ?></h4>
			    <a class="btn btn-primary" href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Logout</a>
				</div>		
				<?php else: ?> <!--Show login-->
		
				
				   <!-- Trigger the modal with a button -->
				 <button type="button" class="btn btn-default btn-lg" id="myBtn">Login</button>
				 
				  <!-- Modal -->
				  <div class="modal fade" id="myModal" role="dialog">
				  <div class="modal-dialog">
				   <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header" style="background_color:green padding:35px 50px;">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
						</div>
						<div class="modal-body" style="padding:40px 50px;">
						  <form role="form" action="includes/login.php" method="post">
							<div class="form-group">
							  <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
								 <input name = "username" type="text" class="form-control" placeholder="Input username">
							</div>
							<div class="form-group">
							  <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
									<input name = "password" type="password" class="form-control" placeholder="Input password">
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" value="" checked>Remember me</label>
							</div>
							  <button type="submit"  name = "login"  class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
						  </form>
						</div>
						<div class="modal-footer">
						  <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>Cancel</button>
						  <p>Not a member? <a href="registration.php">Sign Up</a></p>
						  <p>Forgot <a href="#">Password?</a></p>
						</div>
					  </div>
					</div>
				  </div>

 
				<script>
				$(document).ready(function(){
				  
					$("#myBtn").click(function(){
						$("#myModal").modal({backdrop: false});
					});

				});
				</script>	

				<?php endif; ?>     
				
		
				
            </div><!--End of bar --!>
				