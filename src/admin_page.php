<?php
	require_once("/templates/header.php");
	$is_user = false;
	$is_admin = false;
	// Is someone already logged in? Making sure non-admin can't get in. 
	if(isset($_SESSION['username'])){
		if($_SESSION['isAdmin']){
		  $is_admin = true;
?>

	<div class="container">
		This is the admin Page
	</div>

<?php
		}
		else{
		  $is_user = true;
		  header("Location: user_page.php" );
		  exit();
		}
	}
	else {
		header("Location: index.php" );
		exit();
	}
	$pageTitle = 'Admin';
	require_once("/templates/footer.php");
?>