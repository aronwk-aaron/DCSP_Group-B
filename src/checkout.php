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
      $incomplete = $invalidInput = $zipLenErr  = $zipLenErr2 = $cardLenErr = $expLenErr = $cvvLenErr = $cardNum = $exp = $cvv = $success = $error = $total = '';
      
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
  
      require_once 'inc/login.php';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) 
        die($conn->connect_error);
      
      $total = 0;
      $books = array();
      $returnDates = array();  
      $sql = "SELECT I.title, I.price, uC.isRent, uC.cartID FROM nb_Carts C, nb_userCarts uC, nb_Inventory I WHERE C.userID =" . $_SESSION['user_id'] . " AND uC.cartID = C.cartID AND uC.bookID = I.bookID ;";
      
      $cart = $conn->query($sql);
      if (!$cart) 
        die($conn->error);
        
      $rows = $cart->num_rows;
      for ($j = 0 ; $j < $rows ; ++$j)
      {
        $cart->data_seek($j);
        $row = $cart->fetch_array(MYSQLI_ASSOC);
        array_push($books, $row['title']);
        if($row['isRent'])
        {
          $total += 2;
        }
        else
        {
          $total += $row['price'];
        }
      }
      
      $query = "SELECT firstName, lastName, address, city, state, zip FROM nb_userstable WHERE userName = '" . $_SESSION['username'] . "'";
      
                  
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
      
      if($_POST && !isset($_POST['checkout']))
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
        if(strlen($state2) > 2 && $state2 != "Choose a State") 
        {
          $state2 = $stateAbb[$state2];
        }
        
        $cardNum = sanitizeZip($_POST['cardNum']);
        $exp = sanitizeZip($_POST['exp']);
        $cvv = sanitizeZip($_POST['cvv']);
        
        if($firstName != $_POST['firstName'] || $lastName != $_POST['lastName'] || $address != $_POST['address'] || $city != $_POST['city'] || $zip != $_POST['zip'] || $firstName2 != $_POST['firstName2'] || $lastName2 != $_POST['lastName2'] || $address2 != $_POST['address2'] || $city2 != $_POST['city2'] || $zip2 != $_POST['zip2'] || $cardNum != $_POST['cardNum'] || $exp != $_POST['exp'] || $cvv != $_POST['cvv'])
        {
          $invalidInput = "True";
          $error = "True"; 
        }
    
        if(strlen($zip) != 5)
        {
          $zipLenErr = "True";
          $error = "True";
        }
        
        if(strlen($zip2) != 5)
        {
          $zipLenErr2 = "True";
          $error = "True";
        }
        
        if(strlen($cardNum) != 16)
        {
          $cardLenErr = "True";
          $error = "True";
        }
        
        if(strlen($exp) != 4)
        {
          $expLenErr = "True";
          $error = "True";
        }
        
        if(strlen($cvv) != 3)
        {
          $cvvLenErr = "True";
          $error = "True";
        }
    
        if($_POST && (!$firstName || !$lastName || !$address || !$city || $state =="Choose a State" || !$zip || !$firstName2 || !$lastName2 || !$address2 || !$city2 || $state2 =="Choose a State" || !$zip2 || !isset($_POST['confirm']) || !$cardNum || !$exp || !$cvv))
        {
          $incomplete = "1";
        }
    
        else
        {
          $incomplete = "";
        }
        
        if(!$incomplete && !$error)
        {
          $sql = "INSERT INTO nb_history (userID)
          VALUES ('" . $_SESSION['user_id'] . "')";
          $conn->query($sql);
          
          $sql2 = "SELECT MAX(orderNum) FROM nb_history
          WHERE userID = '" . $_SESSION['user_id'] . "'";
          $result2 = $conn->query($sql2); 
          while($results2 = mysqli_fetch_assoc($result2)) 
          { 
            $orderNum = $results2['MAX(orderNum)'];
          }
          echo($orderNum);
          echo("<br>");
          
          
          $sql3 = "SELECT bookID, isRent from nb_usercarts WHERE cartID = '" . $_SESSION['user_id'] . "'";
          $results3 = $conn->query($sql3);
          $rows = $results3->num_rows;
          for ($j = 0 ; $j < $rows ; ++$j)
          {
            $results3->data_seek($j);
            $row = $results3->fetch_array(MYSQLI_ASSOC);
            $datePurch = date("Y-m-d");
            if($row['isRent'])
            {
              $dueDate = date("Y-m-d",mktime(0, 0, 0, date("m"), date("d") + 14, date("Y")));
              array_push($returnDates, $dueDate);  
            }
            
            else
            {
              $dueDate = Null;
              array_push($returnDates, $dueDate);
            }
            $sql4 = "";
            $sql4 = "INSERT INTO nb_userhistory (orderNum, bookID, datePurch, dueDate)
            VALUES ('" . $orderNum . "', '" . $row['bookID'] . "', '" . $datePurch . "', '" . $dueDate . "')";
            $conn->query($sql4);
            echo($sql4);
            echo("<br>");                  
          }
          $sql5 = "DELETE FROM nb_usercarts WHERE cartID = '" . $_SESSION['user_id'] . "'";
          $conn->query($sql5);
          $_SESSION['books'] = $books;
          $_SESSION['total'] = $total;
          $_SESSION['returnDates'] =  $returnDates;
          header("Location: confirmation.php");  
        }
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
      <p>Please review your billing and shipping information and update if necessary.</p>
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
              <span class="error"><?php if($zipLenErr2) {echo('Please use a five digit zip code.');}?>
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
              else {echo('value='); echo($cardNum);}?> required>
              <span class="error"><?php if($cardLenErr) {echo('Please enter a 16 digit card number.');}?>
              </span>
						</div>
						<div class="form-group col-md-2">
							<label for="inputExpiration">Expiration Date</label>
							<input type="text" name="exp" class="form-control" id="inputExpiration" <?php if(!$_POST || ($_POST && !$exp)) {echo('placeholder="MMYY"');}
              else {echo('value='); echo($exp);}?> required>
              <span class="error"><?php if($expLenErr) {echo('Please enter a four digit expiration date MMYY.');}?>
              </span>
						</div>
					</div>
          <div class="form-row">
					  <div class="form-group col-md-1">
						  <label for="inputCvv">CVV</label>
						  <input type="text" name="cvv" class="form-control" id="inputCvv" <?php if(!$_POST || ($_POST && !$cvv)) {echo('placeholder="XXX"');}
              else {echo('value='); echo($cvv);}?> required>
					 </div>
          </div>
          <span class="error"><?php if($cvvLenErr == "True") {echo('Please enter a three digit CVV code (found on the back of the card).');}?>
          </span>
					       
          
					<div class="form-group">
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="confirm" value="True" required> Accept Terms and Conditions
                <span class="error">
                  <?php if($_POST && !isset($_POST['confirm']) &&!isset($_POST['checkout'])) {echo("Check the box to accept the terms and conditions of NetBooks before checking out.");}?>
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