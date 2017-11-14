<?php
	require_once("/templates/header.php");
	$is_user = false;
	$is_admin = false;
		// Is someone already logged in?
	if(isset($_SESSION['username'])){
		if($_SESSION['isAdmin']){
		  $is_admin = true;
		  header("Location: admin_page.php" );
		  exit();
		}
		else{
		  $is_user = true;
		  header("Location: user_page.php" );
		  exit();
		}
	}
	$err_msg = "";


	//Do registration things here


?>

<div class="container">
	<br>
	<div class="card">
		<div class="card-body">
			<h3 class="card-title"> Register: </h3>
			<form method="post" action="register.php">
				<p class="card-text" style="color: red">
		        	<?php echo $err_msg; ?>
		        </p>
		          <div class="form-group row">
				    <label for="inputFirstname" class="col-sm-2 col-form-label">Firstname:</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" name="username" id="inputUsername" placeholder="Firstname">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputLastname" class="col-sm-2 col-form-label">Lastname:</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" name="lastname" id="inputLastname" placeholder="Lastname">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputUsername" class="col-sm-2 col-form-label">Username:</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" name="username" id="inputUsername" placeholder="Username">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputPasswordCheck" class="col-sm-2 col-form-label">Password Check:</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" name="passwordCheck" id="inputPasswordCheck" placeholder="Password">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputUsername" class="col-sm-2 col-form-label">Stree Address:</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" name="streetAddress" id="inputStreetAddress" placeholder="Street Address">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputCity" class="col-sm-2 col-form-label">City:</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" name="city" id="inputCity" placeholder="City">
				    </div>
				  </div>
				  <div class="form-group row">
				    <label for="inputState" class="col-sm-2 col-form-label">State:</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" name="state" id="inputState" placeholder="State">
				    </div>
				  </div>
				<input type="submit" value="Register">
			</form>
		</div>
	</div>
</div>

<?php
	$pageTitle = 'Register';
	require_once("/templates/footer.php");
?>