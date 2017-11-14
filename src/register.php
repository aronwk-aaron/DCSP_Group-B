<?php
	require_once("templates/header.php");
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
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputUsername">Username</label>
							<input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username">
						</div>
						<div class="form-group col-md-6">
							<label for="inputPassword">Password</label>
							<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Address</label>
						<input type="text" name="address" class="form-control" id="inputAddress" placeholder="1234 Main St">
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCity">City</label>
							<input type="text" name="city" class="form-control" id="inputCity">
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">State</label>
							<select id="inputState" name="state" class="form-control">
								<option selected>Choose a State</option>
								<option value="AL">Alabama</option>
								<option value="AK">Alaska</option>
								<option value="AZ">Arizona</option>
								<option value="AR">Arkansas</option>
								<option value="CA">California</option>
								<option value="CO">Colorado</option>
								<option value="CT">Connecticut</option>
								<option value="DE">Delaware</option>
								<option value="DC">District Of Columbia</option>
								<option value="FL">Florida</option>
								<option value="GA">Georgia</option>
								<option value="HI">Hawaii</option>
								<option value="ID">Idaho</option>
								<option value="IL">Illinois</option>
								<option value="IN">Indiana</option>
								<option value="IA">Iowa</option>
								<option value="KS">Kansas</option>
								<option value="KY">Kentucky</option>
								<option value="LA">Louisiana</option>
								<option value="ME">Maine</option>
								<option value="MD">Maryland</option>
								<option value="MA">Massachusetts</option>
								<option value="MI">Michigan</option>
								<option value="MN">Minnesota</option>
								<option value="MS">Mississippi</option>
								<option value="MO">Missouri</option>
								<option value="MT">Montana</option>
								<option value="NE">Nebraska</option>
								<option value="NV">Nevada</option>
								<option value="NH">New Hampshire</option>
								<option value="NJ">New Jersey</option>
								<option value="NM">New Mexico</option>
								<option value="NY">New York</option>
								<option value="NC">North Carolina</option>
								<option value="ND">North Dakota</option>
								<option value="OH">Ohio</option>
								<option value="OK">Oklahoma</option>
								<option value="OR">Oregon</option>
								<option value="PA">Pennsylvania</option>
								<option value="RI">Rhode Island</option>
								<option value="SC">South Carolina</option>
								<option value="SD">South Dakota</option>
								<option value="TN">Tennessee</option>
								<option value="TX">Texas</option>
								<option value="UT">Utah</option>
								<option value="VT">Vermont</option>
								<option value="VA">Virginia</option>
								<option value="WA">Washington</option>
								<option value="WV">West Virginia</option>
								<option value="WI">Wisconsin</option>
								<option value="WY">Wyoming</option>
							</select>
						</div>
						<div class="form-group col-md-2">
							<label for="inputZip">Zip</label>
							<input type="text" name="zip" class="form-control" id="inputZip">
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="confirm"> Confirm
							</label>
						</div>
					</div>
				<button type="submit" class="btn btn-dark">Register</button>
				</form>
		</div>
	</div>
</div>

<?php
	$pageTitle = 'Register';
	require_once("templates/footer.php");
?>