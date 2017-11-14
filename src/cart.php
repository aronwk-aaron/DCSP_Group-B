<?php
	require_once("templates/header.php");
	$is_user = false;
	$is_admin = false;
	// Is someone already logged in? Making sure admin can't get on user page
	if(isset($_SESSION['username'])){
		if($_SESSION['isAdmin']){
		  $is_admin = true;
		  header("Location: admin_page.php" );
		  exit();
		}
		else{
		  	$is_user = true;
?>

	<div class="container">
		This is the cart Page
	</div>

<?php
		}
		
	}
	else {
		header("Location: index.php" );
		exit();
	}
	$pageTitle = 'Cart';
	require_once("templates/footer.php");
?>