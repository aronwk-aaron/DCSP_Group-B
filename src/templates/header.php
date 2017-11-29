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
	<body class="bg-dark">
		<noscript style="color: red;" >Turn JavaScript back on, please!</noscript>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">NetBooks</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarMain">
		    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		      <li class="nav-item">
		        <a class="nav-link" href="index.php">Home</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="browse.php">Browse</a>
		      </li>
		     </ul>
		      <?php
		      	if($is_user){
		      		?>
	      			<ul class="navbar-nav">
                    <li class="nav-item dropdown">
		                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                      Hello, <?php print($_SESSION['firstname']); ?>
		                    </a>
		                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="user_page.php">User Page</a>
								<a class="dropdown-item" href="profile_change.php">Update Account</a>
		                    </div>
		                </li>
			            <li class="nav-item" >
			              <a class="nav-link" href="cart.php">Cart</a>
			            </li>
						<li class="nav-item" >
							<a class="nav-link" href="logout.php">Logout</a>
						</li>
		            </ul>
			    	<?php
		  		}
		  		if($is_admin){
		  			?>
		  			<ul class="navbar-nav">
		                <li class="nav-item dropdown">
		                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                      Hello, <?php print($_SESSION['firstname']); ?>
		                    </a>
		                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="admin_page.php">Admin Page</a>
								<a class="dropdown-item" href="add_book.php">Add Book</a>
		                    </div>
		                </li>
						<li class="nav-item" >
							<a class="nav-link" href="logout.php">Logout</a>
						</li>
		            </ul>
				    <?php
		  		}
		  		if((!($is_user))&&(!($is_admin))){
		  			?>
		  			<ul class="navbar-nav">
						<li class="nav-item" >
							<a class="nav-link" href="login_page.php">Login</a>
						</li>
						<li class="nav-item" >
							<a class="nav-link" href="register.php">Register</a>
						</li>
					</ul>
		  			<?php
		  		}
		      ?>
		    </ul>
		  </div>
		</nav>