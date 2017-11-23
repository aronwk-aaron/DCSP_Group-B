<?php
	require_once("templates/header.php");
	if(isset($_SESSION['username'])){
		if($is_admin){
		  header("Location: admin_page.php" );
		  exit();
		}
		else{
		  	$is_user = true;
?>
			<script type="text/javascript">
				var page_title = "NetBooks - Cart";
			</script>

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
	require_once("templates/footer.php");
?>