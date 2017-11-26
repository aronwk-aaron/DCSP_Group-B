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

  <?php
    require_once 'inc/login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) 
      die($conn->connect_error);
      
      
    // Perform two queries to get the user's ID, then use that to get info from the cart     
    $query = "SELECT userID FROM nb_UsersTable WHERE userName = $_SESSION['userName']";
	  $result = $connection->query($query);

	  if (!$result) die($conn->error);
	  else if ($result->num_rows)
	  {
	      $row = $result->fetch_array(MYSQLI_ASSOC);
	      $result->close();
           
        $userID = $row['userID'];
           
    $query  = "SELECT I.title, I.ISBN, I.price, uC.isRent FROM nb_Carts C, nb_userCarts uC, nb_Inventory I WHERE C.userID = $userID AND uC.cartID = C.cartID AND uC.bookID = I.bookID ;";

    $result = $conn->query($query);
    if (!$result) 
      die($conn->error);

    $rows = $result->num_rows;
    
    if $rows == 0 {
      echo 'There is nothing in the cart!'
    }  
    
    else{
      echo'<table>';
      echo'<tr><th>Title</th><th>ISBN</th><th>Price</th><th>Rent?</th></tr>';
        
      //table display
      for ($j = 0 ; $j < $rows ; ++$j)
      {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $isRent = "No";
        if($row['uC.isRent'] == 1)
          $isRent = "Yes";
        
  
        echo '<tr><td>' . $row['I.title']    . '</td>';
        echo '<td>'     . $row['I.ISBN']     . '</td>';
        echo '<td>'     . $row['I.price']    . '</td>';
        echo '<td>'     . $inStock           . '</td></tr>';
      }
      
      echo'</table>';
    }
    
    $connection->close();           
  ?>
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