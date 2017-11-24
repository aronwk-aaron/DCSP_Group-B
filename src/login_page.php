<?php
	require_once("templates/header.php");
	// Is someone already logged in?
	if(isset($_SESSION['username'])){
		if($is_admin){
		  header("Location: admin_page.php" );
		  exit();
		}
		else{
		  header("Location: user_page.php" );
		  exit();
		}
	}

	require_once('inc/login.php');
	$connection = new mysqli($hn, $un, $pw, $db);

	$un_temp = "";
	$pw_temp = "";
	$err_msg = "";
	$is_admin = false;
	$is_user = false;

	if ($connection->connect_error) die($connection->connect_error);

	if (isset($_POST['username']) && isset($_POST['password']))
	{
	  $un_temp = mysql_entities_fix_string($connection, $_POST['username']);
	  $pw_temp = mysql_entities_fix_string($connection, $_POST['password']);

	  $salt1 = "qm&h*";
	  $salt2 = "pg!@";
	  $token = hash('ripemd128', "$salt1$pw_temp$salt2");

	  $query = "SELECT * FROM nb_userstable WHERE userName='$un_temp' AND password='$token'";
	  $result = $connection->query($query);

	  if (!$result) die($connection->error);
	  else if ($result->num_rows)
	  {
	      $row = $result->fetch_array(MYSQLI_ASSOC);
	      $result->close();

          //      If username / password were valid, set session variables
          //      and forward them to the correct page
          $_SESSION['user_id']		= $row['userID'];
          $_SESSION['username'] 	= $un_temp;
          $_SESSION['firstname'] 	= $row['firstName'];
          $_SESSION['lastname']  	= $row['lastName'];
          $_SESSION['address']		= $row['address'];
          $_SESSION['city']			= $row['city'];
          $_SESSION['state']		= $row['state'];
          $_SESSION['zip']			= $row['zip'];
          $_SESSION['isAdmin']		= $row['isAdmin'];
          $connection->close();
          if($_SESSION['isAdmin']){
            	$is_admin = true;
            	header("Location: admin_page.php" );
		  		exit();
          }
          elseif (!($_SESSION['isAdmin'])) {
            $is_user = true;
            header("Location: user_page.php" );
		  	exit();
          }
	      //      If the username / password were not valid, show error message
	      //      and populate form with the original inputs
	      else $err_msg = "The username / password combination is not correct.";
	  }
	  else $err_msg = "The username / password combination is not correct.";
	}
	else if(isset($_POST['username'])){
	  $un_temp = mysql_entities_fix_string($connection, $_POST['username']);
	  $err_msg = "The username / password combination is not correct.";
	}
	else if(isset($_POST['password'])){
	  $pw_temp = mysql_entities_fix_string($connection, $_POST['password']);
	  $err_msg = "The username / password combination is not correct.";
	}

	//
	function mysql_entities_fix_string($connection, $string){
		return htmlentities(mysql_fix_string($connection, $string));
	} 

	function mysql_fix_string($connection, $string){
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return $connection->real_escape_string($string);
	}
?>
<script type="text/javascript">
	var page_title = "NetBooks - Login";
</script>
<div class="container">
	<br>
	<div class="card">
		<div class="card-body">
			<h3 class="card-title"> Login: </h3>
			<form method="post" action="login_page.php">
				<p class="card-text" style="color: red">
		        	<?php echo $err_msg; ?>
		        </p>
				  <div class="form-group row">
				    <label for="staticEmail" class="col-sm-2 col-form-label">Username:</label>
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
				<input type="submit" value="Log in">
			</form>
		</div>
	</div>
</div>

<?php
	require_once("templates/footer.php");
?>