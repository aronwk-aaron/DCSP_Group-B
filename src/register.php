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

  $username = $password = $firstName = $lastName = $address = $city = $state = $zip = $incomplete = $error = $successful = $uid = "";
  
  $salt1 = "qm&h*";
	$salt2 = "pg!@";
  
  $states = [
  "AL" => "Alabama",
	"AK" => "Alaska",
	"AZ" => "Arizona",
  "AR" => "Arkansas",
  "CA" => "California",
  "CO" => "Colorado",
  "CT" => "Connecticut",
  "DE" => "Delaware",
  "DC" => "District Of Columbia",
  "FL" => "Florida",
  "GA" => "Georgia",
  "HI" => "Hawaii",
  "ID" => "Idaho",
  "IL" => "Illinois",
  "IN" => "Indiana",
  "IA" => "Iowa",
  "KS" => "Kansas",
  "KY" => "Kentucky",
  "LA" => "Louisiana",
  "ME" => "Maine",
  "MD" => "Maryland",
  "MA" => "Massachusetts",
  "MI" => "Michigan",
  "MN" => "Minnesota",
  "MS" => "Mississippi",
  "MO" => "Missouri",
  "MT" => "Montana",
  "NE" => "Nebraska",
  "NV" => "Nevada",
  "NH" => "New Hampshire",
  "NJ" => "New Jersey",
  "NM" => "New Mexico",
  "NY" => "New York",
  "NC" => "North Carolina",
  "ND" => "North Dakota",
  "OH" => "Ohio",
  "OK" => "Oklahoma",
  "OR" => "Oregon",
  "PA" => "Pennsylvania",
  "RI" => "Rhode Island",
  "SC" => "South Carolina",
  "SD" => "South Dakota",
  "TN" => "Tennessee",
  "TX" => "Texas",
  "UT" => "Utah",
  "VT" => "Vermont",
  "VA" => "Virginia",
  "WA" => "Washington",
  "WV" => "West Virginia",
  "WI" => "Wisconsin",
  "WY" => "Wyoming",
  ];
  
  $stateAbb = array_flip($states);
  
	if($_POST)
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    if(strlen($state) > 2)
      {
        $state = $stateAbb[$state];
      }
    
    if($_POST && (!$username || !$password || !$address || !$city || $state =="Choose a State" || !$zip))
    {
      $incomplete = "1";
    }
    
    else
    {
      $incomplete = "";
    }
    
    if(!$error && !$incomplete)
    {
      require_once 'inc/login.php';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) 
        die($conn->connect_error);
      
      $uid = 4;
      $sql = "INSERT INTO nb_UsersTable
      VALUES ('" . $uid . "', '" . $username . "', '" . $firstName . "', '" . $lastName . "', '" . $salt1.$password.$salt2 . "', '" . $address . "', '" . $city . "', '" . $state . "', " . "'false', 'false')";
      
      if($conn->query($sql) === TRUE)
      {
        $successful = "True";
      }
      
      $conn->close();
    }
  }

?>

<div class="container">
	<br>
	<div class="card">
		<div class="card-body">
			<h3 class="card-title"> Register: </h3>
      <?php if($successful) {echo('Account creation successful!');}?>
      <style>
            .error {color: #FF0000;}
      </style>
      <?php if($incomplete) {echo('<p><span class="error">All form fields must be completed to register for NetBooks.</span></p>');}?>
			<form method="post" action="register.php">
				<p class="card-text" style="color: red">
		        	<?php echo $err_msg; ?>
		        </p>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputUsername">Username</label>
							<input type="text" name="username" class="form-control" id="inputUsername" <?php if(!$_POST || ($_POST && !$username)) {echo('placeholder="Username"');}
              else {echo('value='); echo($username);}?>>
						</div>
						<div class="form-group col-md-6">
							<label for="inputPassword">Password</label>
							<input type="password" name="password" class="form-control" id="inputPassword" <?php if(!$_POST || ($_POST && !$password)) {echo('placeholder="Password"');}
              else {echo('value='); echo($password);}?>>
						</div>
					</div>
          <div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputFirstName">First Name</label>
							<input type="text" name="firstName" class="form-control" id="inputFirstName" <?php if(!$_POST || ($_POST && !$firstName)) {echo('placeholder="John"');}
              else {echo('value='); echo($firstName);}?>>
						</div>
						<div class="form-group col-md-6">
							<label for="inputLastName">Last Name</label>
							<input type="text" name="lastName" class="form-control" id="inputLastName" <?php if(!$_POST || ($_POST && !$lastName)) {echo('placeholder="Doe"');}
              else {echo('value='); echo($lastName);}?>>
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Address</label>
						<input type="text" name="address" class="form-control" id="inputAddress" <?php if(!$_POST || ($_POST && !$address)) {echo('placeholder="1234 Main St"');}
              else {echo('value='); echo($address);}?>>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCity">City</label>
							<input type="text" name="city" class="form-control" id="inputCity" <?php if(!$_POST || ($_POST && !$city)) {echo('placeholder="Townsville"');}
              else {echo('value='); echo($city);}?>>
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">State</label>
							<select id="inputState" name="state" class="form-control">
								<?php if(!$_POST || ($_POST && $state =="Choose a State")) {echo('<option selected>Choose a State</option>');}
                else {echo('<option selected>'); echo($states[$state]); echo('</option>');}?>
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
							<input type="text" name="zip" class="form-control" id="inputZip" <?php if(!$_POST || ($_POST && !$zip)) {echo('placeholder="12345"');}
              else {echo('value='); echo($zip);}?>>
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="confirm" value="True"> Confirm
                <span class="error">
                  <?php if($_POST && !isset($_POST['confirm'])) {echo("Check the box to confirm your submission and click 'Register'");}?>
                </span>
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