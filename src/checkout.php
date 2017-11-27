  <?php
	require_once("templates/header.php");
  if(!isset($_SESSION['username']))
  {
    header("Location: login_page.php");
  }
	if(isset($_SESSION['username']))
  {
		if($is_admin)
    {
		  header("Location: admin_page.php" );
		  exit();
		}
		else
    {
      $incomplete = $invalidInput = $zipLenErr = $cardNum = $exp = $cvv = $success = '';
      
      $sql = $query  = "SELECT firstName, lastName, address, city, state, zip FROM nb_userstable WHERE userName = '" . $_SESSION['username'] . "'";
      require_once 'inc/login.php';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) 
        die($conn->connect_error);
                  
      $result = $conn->query($query);
      if (!$result) 
        die($conn->error);
      
      $userInfo = $result->fetch_array(MYSQLI_ASSOC);
      $firstName = $firstName2 = $userInfo['firstName'];
      $lastName = $lastName2 = $userInfo['lastName'];
      $address = $address2 = $userInfo['address'];
      $city = $city2 = $userInfo['city'];
      $state = $state2 = $userInfo['state'];
      $zip = $zip2 = $userInfo['zip'];
      
      if($_POST)
      {
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
        
        $firstName2 = sanitizeString($_POST['firstName2']);
        $lastName2 = sanitizeString($_POST['lastName2']);
        $address2 = sanitizeAddress($_POST['address2']);
        $city2 = sanitizeString($_POST['city2']);
        $state2 = $_POST['state2'];
        $zip2 = sanitizeZip($_POST['zip2']);
        if(strlen($state) > 2 && $state2 != "Choose a State") 
        {
          $state = $stateAbb[$state];
        }
        
        $cardNum = sanitizeZip($_POST['cardNum']);
        $exp = sanitizeZip($_POST['exp']);
        $cvv = sanitizeZip($_POST['cvv']);
        
        if($success)
        
      }    
  ?>
  
  <script type="text/javascript">
  var page_title = "NetBooks - Checkout";
</script>
<div class="container">
	<br>
	<div class="card">
		<div class="card-body">
			<h3 class="card-title"> Checkout: </h3>
      <h4 class="card-title"> Billing Information </h4>
      <style>
            .error {color: #FF0000;}
      </style>
      <p><span class="error">
        <?php if($incomplete) {echo('All fields must be completed to checkout.<br>');}
        if($invalidInput) {echo('Invalid special characters deleted. Check fields and resubmit.');}?>
      </span></p>
			<form method="post" action="checkout.php">
          <div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputFirstName">First Name</label>
							<input type="text" name="firstName" class="form-control" id="inputFirstName" <?php if(!$_POST || ($_POST && !$firstName)) {echo('value="' . $firstName . '"');}
              else {echo('value='); echo($firstName);}?>>
						</div>
						<div class="form-group col-md-6">
							<label for="inputLastName">Last Name</label>
							<input type="text" name="lastName" class="form-control" id="inputLastName" <?php if(!$_POST || ($_POST && !$lastName)) {echo('value="' . $lastName . '"');}
              else {echo('value='); echo($lastName);}?>>
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Address</label>
						<input type="text" name="address" class="form-control" id="inputAddress" <?php if(!$_POST || ($_POST && !$address)) {echo('value="' . $address . '"');}
              else {echo('value='); echo('"' . $address) . '"';}?>>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCity">City</label>
							<input type="text" name="city" class="form-control" id="inputCity" <?php if(!$_POST || ($_POST && !$city)) {echo('value="' . $city . '"');}
              else {echo('value='); echo($city);}?>>
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">State</label>
							<select id="inputState" name="state" class="form-control">
								<?php if(!$_POST || ($_POST && $state =="Choose a State")) {echo('<option selected>' . $state . '</option>');}
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
							<input type="text" name="zip" class="form-control" id="inputZip" <?php if(!$_POST || ($_POST && !$zip)) {echo('value="' . $zip . '"');}
              else {echo('value='); echo($zip);}?>>
              <span class="error"><?php if($zipLenErr) {echo('Please use a five digit zip code.');}?>
              </span>
						</div>
					</div>
              <br>
              <br>
              
              
              
              
              <h4 class="card-title"> Shipping Information </h4>
      <style>
            .error {color: #FF0000;}
      </style>
          <div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputFirstName">First Name</label>
							<input type="text" name="firstName2" class="form-control" id="inputFirstName" <?php if(!$_POST || ($_POST && !$firstName2)) {echo('value="' . $firstName2 . '"');}
              else {echo('value='); echo($firstName2);}?>>
						</div>
						<div class="form-group col-md-6">
							<label for="inputLastName">Last Name</label>
							<input type="text" name="lastName2" class="form-control" id="inputLastName" <?php if(!$_POST || ($_POST && !$lastName2)) {echo('value="' . $lastName2 . '"');}
              else {echo('value='); echo($lastName2);}?>>
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Address</label>
						<input type="text" name="address2" class="form-control" id="inputAddress" <?php if(!$_POST || ($_POST && !$address2)) {echo('value="' . $address2 . '"');}
              else {echo('value='); echo('"' . $address2) . '"';}?>>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputCity">City</label>
							<input type="text" name="city2" class="form-control" id="inputCity" <?php if(!$_POST || ($_POST && !$city2)) {echo('value="' . $city2 . '"');}
              else {echo('value='); echo($city2);}?>>
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">State</label>
							<select id="inputState" name="state2" class="form-control">
								<?php if(!$_POST || ($_POST && $state2 =="Choose a State")) {echo('<option selected>' . $state2 . '</option>');}
                else {echo('<option selected>'); echo($states[$state2]); echo('</option>');}?>
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
							<input type="text" name="zip2" class="form-control" id="inputZip" <?php if(!$_POST || ($_POST && !$zip2)) {echo('value="' . $zip2 . '"');}
              else {echo('value='); echo($zip2);}?>>
              <span class="error"><?php if($zipLenErr) {echo('Please use a five digit zip code.');}?>
              </span>
						</div>
					</div>
          <br>
          <br>
          
          
          <h4 class="card-title"> Card Information </h4>
      <style>
            .error {color: #FF0000;}
      </style>
          <div class="form-row">
						<div class="form-group col-md-3">
							<label for="inputCardNumber">Card Number</label>
							<input type="text" name="cardNum" class="form-control" id="cardNum" <?php if(!$_POST || ($_POST && !$cardNum)) {echo('placeholder="XXXX-XXXX-XXXX-XXXX"');}
              else {echo('value='); echo($cardNum);}?>>
						</div>
						<div class="form-group col-md-2">
							<label for="inputExpiration">Expiration Date</label>
							<input type="text" name="exp" class="form-control" id="inputLastName" <?php if(!$_POST || ($_POST && !$exp)) {echo('placeholder="MMYY"');}
              else {echo('value='); echo($exp);}?>>
						</div>
					</div>
          <div class="form-row">
					  <div class="form-group col-md-1">
						  <label for="inputAddress">CVV</label>
						  <input type="text" name="cvv" class="form-control" id="inputCvv" <?php if(!$_POST || ($_POST && !$cvv)) {echo('placeholder="XXX"');}
              else {echo('value='); echo('"' . $address2) . '"';}?>>
					 </div>
          </div>
					       
          
					<div class="form-group">
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="confirm" value="True"> Accept Terms and Conditions
                <span class="error">
                  <?php if($_POST && !isset($_POST['confirm'])) {echo("Check the box to accept the terms and conditions of NetBooks before checking out.");}?>
                </span>
							</label>
						</div>
					</div>
				<button type="submit" class="btn btn-dark">Checkout</button>
				</form>
		</div>
	</div>
</div>

<?php
	require_once("templates/footer.php");
?>
    
  <?php
    }
  }

        

	else 
  {
		header("Location: index.php" );
		exit();
  }
    ?>
<?php
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
	require_once("templates/footer.php");
  $conn->close();
?>