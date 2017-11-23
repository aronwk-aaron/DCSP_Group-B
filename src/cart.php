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
				<div class="card">
				  <div class="card-body">
				    <h4 class="card-title"> <?php print($_SESSION['firstname'])?>'s Cart</h4>
				    <p class="card-text">
				    	Do cart things here
				    </p>
				  </div>
				</div>
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