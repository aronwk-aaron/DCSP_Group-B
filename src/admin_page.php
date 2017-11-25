<?php
	require_once("templates/header.php");
	$is_user = false;
	$is_admin = false;
	// Is someone already logged in? Making sure non-admin can't get in. 
	if(isset($_SESSION['username'])){
		if($_SESSION['isAdmin']){
		    $is_admin = true;

		  //Query up stuff
            require_once 'inc/login.php';
            $conn = new mysqli($hn, $un, $pw, $db);
            if ($conn->connect_error)
                die($conn->connect_error);

            $userName = $_SESSION['username'];
            $query  = "SELECT * FROM nb_userstable WHERE userName = '$userName'";
            $result = $conn->query($query);
            if (!$result){
                die($conn->error);}

            $result->data_seek(0);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            ?>

            <style>
                /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
                .row.content {height: 1500px}

                /* Set gray background color and 100% height */
                .sidenav {
                    background-color: #f1f1f1;
                    height: 100%;
                }

                /* Set black background color, white text and some padding */
                footer {
                    background-color: #555;
                    color: white;
                    padding: 15px;
                }

                /* On small screens, set height to 'auto' for sidenav and grid */
                @media screen and (max-width: 767px) {
                    .sidenav {
                        height: auto;
                        padding: 15px;
                    }
                    .row.content {height: auto;}

            </style>
            </head>
            <body>
            <div class="container-fluid">
                <div class="row content">
                    <div class="col-sm-3 sidenav">
                        <h4> <?php print($_SESSION['username']); ?>'s Shelf</h4>
                        <!-- class="nav nav-pills nav-stacked" for the ul-->
                        <ul>
                            <li><a href="history_display.php">History & Due Dates</a></li>
                            <li><a href="profile_change.php">Change Profile</a></li>
                        </ul><br>
                    </div>

                    <div class="col-sm-9">
                        <h4><small>Profile</small></h4>
                        <hr>
                        <h2><?php print(($_SESSION['firstname']) . ' ' . ($_SESSION['lastname'])); ?></h2>
                        <h5><?php print($row['address']);?></h5>
                        <h5><?php print($row['city'] . ', ' . $row['state']);?></h5><br>
                        <br><br>
                    </div>
                </div>
            </div>

            <footer class="container-fluid">
                <p>Footer Text</p>
            </footer>

            </body>

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
	require_once("templates/footer.php");
?>