<?php
	$is_user = false;
	$is_admin = false;
	session_start();
	// Is someone already logged in?
	if(isset($_SESSION['username'])){
		if($_SESSION['isAdmin']){
		  $is_admin = true;
		}
		else{
		  $is_user = true;
		}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<title>NetBooks</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<!-- Datatables CSS -->
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">

	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <a class="navbar-brand" href="index.php">NetBooks</a>

		  <div class="collapse navbar-collapse" id="navbarMain">
		    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		      <li class="nav-item">
		        <a class="nav-link" href="index.php">Home</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="browse.php">Browse</a>
		      </li>
		      <?php
		      	if($is_user){
		      		?>
						<li class="nav-item" >
							<a class="nav-link" href="user_page.php">User Page</a>
						</li>
						<li class="nav-item" >
							<a class="nav-link" href="cart.php">Cart</a>
						</li>
						<li class="nav-item" >
							<a class="nav-link" href="logout.php">Logout</a>
						</li>
			    	<?php
		  		}
		  		if($is_admin){
		  			?>
			  			<li class="nav-item" >
							<a class="nav-link" href="admin_page.php">Admin Page</a>
					    </li>
					    <li class="nav-item" >
							<a class="nav-link" href="logout.php">Logout</a>
				      	</li>
				    <?php
		  		}
		  		if((!($is_user))&&(!($is_admin))){
		  			?>
						<li class="nav-item" >
							<a class="nav-link" href="login_page.php">Login</a>
						</li>
						<li class="nav-item" >
							<a class="nav-link" href="register.php">Register</a>
						</li>
		  			<?php
		  		}
		      ?>
		    </ul>
		  </div>
		</nav>