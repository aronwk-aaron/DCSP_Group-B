<?php
	require_once("templates/header.php");
	//kicking out the wrong people
	if(isset($_SESSION['username'])){
		if($is_admin){
?>
			<script type="text/javascript">
				var page_title = "NetBooks - Admin";
			</script>

			<div class="container">
			<br><br>
			<div class="container">
				<div class="card-deck">
				  <div class="card border-dark" style="max-width: 15rem;">
				  	<div class="card-header">Welcome Administrator!</div>
				    <div class="card-body text-dark">
				      <h4 class="card-title">
				      	<?php print($_SESSION['firstname']);?>
				      	<?php print($_SESSION['lastname']);?>
				      </h4>
				      <p class="card-text">
				      	You are the boss
				      	<!-- put other useful info here -->
				      <p>
				    </div>
				  </div>
				  <div class="card">
				    <div class="card-body">
				      <h4 class="card-title">Admin Tools</h4>
				      <p class="card-text">
				      	<ul class="nav nav-tabs" id="myTab" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link active" id="history-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">History</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Inventory</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link" id="users-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Users</a>
						  </li>
						</ul>
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="history-tab">
						  	Just do it
						  </div>
						  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="inventory-tab">
						  	Don't let your memes be dreams
						  </div>
						  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="users-tab">
						  	Just Freaking do it
						  </div>
						</div>
				      </p>
				    </div>
				  </div>
				</div>
			</div>
			</div>

<?php
		}
		else{
		  header("Location: user_page.php" );
		  exit();
		}
	}
	else {
		header("Location: index.php" );
		exit();
	}
	require_once("templates/footer.php");
?>