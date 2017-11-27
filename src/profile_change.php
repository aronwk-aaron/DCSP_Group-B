<?php
	require_once("templates/header.php");
	$err_msg = "";

    $defaultFirstName = $_SESSION['firstname'];
    $defaultLastName =  $_SESSION['lastname'];
    $defaultAddress = $_SESSION['address'];
    $defaultCity = $_SESSION['city'];
    $defaultState = $_SESSION['state'];
    $defaultZip = $_SESSION['zip'];
    $password = $incomplete = $error = $successful = $invalidInput = $zipLenErr = "";
  
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
  
  if(strlen($defaultState) > 2 && $state != "Choose a State") 
      {
        $defaultState = $stateAbb[$defaultState];
      }
  
	if($_POST)
  {
    $password = $_POST['password'];
    $firstName = sanitizeString($_POST['firstName']);
    $lastName = sanitizeString($_POST['lastName']);
    $address = sanitizeAddress($_POST['address']);
    $city = sanitizeString($_POST['city']);
    $state = $_POST['state'];
    $zip = sanitizeZip($_POST['zip']);
    if(strlen($state) > 2 && $state != "Choose a State") 
      {
        $state = $stateAbb[$state];
      }
      
    if($firstName != $_POST['firstName'] || $lastName != $_POST['lastName'] || $address != $_POST['address'] || $city != $_POST['city'] || $zip != $_POST['zip'])
    {
      $invalidInput = "True";
      $error = "True"; 
    }
    
    if(strlen($zip) > 5)
    {
      $zipLenErr = "True";
      $error = "True";
    }
    
    if($_POST && (!$password || !$address || !$city || $state =="Choose a State" || !$zip))
    {
      $incomplete = "1";
    }
    
    else
    {
      $incomplete = "";
    }
    
    $token = passHash($password);
    
    require_once 'inc/login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) 
      die($conn->connect_error);
    
    if(!isset($_POST['confirm']))
    {
      $error = "True";
    }
    
    if(!$error && !$incomplete)
    {
      $sql = "UPDATE nb_userstable
      SET firstname = '" . $firstName . "', lastname = '" . $lastName . "', password = '" . $token . "', address = '" . $address . "', city = '" . $city . "', state = '" . $state . "', zip = '" . $zip . "' WHERE userID = '" . $_SESSION['user_id'] . "'";
      
      echo($sql);
      if($conn->query($sql) === TRUE)
      {
        $successful = "True";
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['address'] = $address;
        $_SESSION['city'] = $city;
        $_SESSION['state'] = $state;
        $_SESSION['zip'] = $zip;
      }
      
    }
    
    $conn->close();
  }
  
  
  function sanitizeString($var)
  { 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $var);
  }
  
  function sanitizeAddress($var)
  {
    return preg_replace('/[^A-Za-z0-9\040]/', '', $var);
  }
  
  
  function sanitizeZip($var)
  {
    return preg_replace('/[^0-9]/', '', $var);
  }
  
  
  function passHash($password)
  {
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
    $hashed = hash('ripemd128', "$salt1$password$salt2");
    return $hashed;  
  }

?>
<script type="text/javascript">
  var page_title = "NetBooks - Update Information";
</script>
<div class="container">
	<br>
	<div class="card">
		<div class="card-body">
			<h3 class="card-title"> Update Account Information: </h3>
      <span style="color:blue;font-weight:bold;text-align:center;">
      <?php if($successful) {echo('Account data updated!');}?>
      </span>
      <style>
            .error {color: #FF0000;}
      </style>
      <p><span class="error">
        <?php if($incomplete) {echo('All form fields must be completed to register for NetBooks.<br>');}
        if($invalidInput) {echo('Invalid special characters deleted. Check fields and resubmit.');}?>
      </span></p>
			<form method="post" action="profile_change.php">
				<p class="card-text" style="color: red">
		        	<?php echo $err_msg; ?>
		        </p>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputPassword">Password</label>
							<input type="password" name="password" class="form-control" id="inputPassword">
						</div>
					</div>
          <div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputFirstName">First Name</label>
							<input type="text" name="firstName" class="form-control" id="inputFirstName" <?php if(!$_POST || ($_POST && !$firstName)) {echo('value=' . $defaultFirstName);}
              else {echo('value='); echo($firstName);}?>>
						</div>
						<div class="form-group col-md-6">
							<label for="inputLastName">Last Name</label>
							<input type="text" name="lastName" class="form-control" id="inputLastName" <?php if(!$_POST || ($_POST && !$lastName)) {echo('value=' . $defaultLastName);}
              else {echo('value='); echo($lastName);}?>>
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Address</label>
						<input type="text" name="address" class="form-control" id="inputAddress" <?php if(!$_POST || ($_POST && !$address)) {echo('value=' . $defaultAddress);}
              else {echo('value='); echo('"' . $address) . '"';}?>>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCity">City</label>
							<input type="text" name="city" class="form-control" id="inputCity" <?php if(!$_POST || ($_POST && !$city)) {echo('value=' . $defaultCity);}
              else {echo('value='); echo($city);}?>>
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">State</label>
							<select id="inputState" name="state" class="form-control">
								<?php if(!$_POST) {echo('<option selected>'); echo($defaultState);}
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
							<input type="text" name="zip" class="form-control" id="inputZip" <?php if(!$_POST || ($_POST && !$zip)) {echo('value=' . $defaultZip);}
              else {echo('value='); echo($zip);}?>>
              <span class="error"><?php if($zipLenErr) {echo('Please use a five digit zip code.');}?>
              </span>
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
				<button type="submit" class="btn btn-dark">Update</button>
				</form>
		</div>
	</div>
</div>

<?php
	$pageTitle = 'Profile Change';
	require_once("templates/footer.php");
?>