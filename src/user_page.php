<?php
	require_once("templates/header.php");
	if(isset($_SESSION['username'])){
		if($is_admin){
		  header("Location: admin_page.php" );
		  exit();
		}
		else{
?>
			<script type="text/javascript">
				var page_title = "NetBooks - User";
			</script>
			<br><br>
			<div class="container">
				<div class="card-deck">
				  <div class="card border-dark" style="max-width: 15rem;">
				  	<div class="card-header">Welcome!</div>
				    <div class="card-body text-dark">
				      <h4 class="card-title">
				      	<?php print($_SESSION['firstname']);?>
				      	<?php print($_SESSION['lastname']);?>
				      </h4>
				      <p class="card-text">
				      	Address: <br>
				      	<?php print($_SESSION['address']);?><br>
				      	<?php print($_SESSION['city']);?>, <?php print($_SESSION['state']);?> <?php print($_SESSION['zip']);?><br>
				      	<!-- put other useful info here -->
				      <p>
				    </div>
				  </div>
				  <div class="card">
				    <div class="card-body">
				      <h4 class="card-title">Purchase History</h4>
				      <p class="card-text">
				      	Print user history here.<br>
				      </p>
				    </div>
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