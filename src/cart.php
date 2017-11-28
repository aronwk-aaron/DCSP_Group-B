<?php
	require_once("templates/header.php");
	if(isset($_SESSION['username'])){
		if($is_admin){
		  header("Location: admin_page.php" );
		  exit();
		}
		else{
		  	$is_user = true;
        $total = 0;
?>
			<script type="text/javascript">
				var page_title = "NetBooks - Cart";
			</script>

			<div class="container">
				<div class="card">
				  <div class="card-body">
				    <h4 class="card-title"> <?php print($_SESSION['firstname'])?>'s Cart</h4>
				    <p class="card-text">
              <?php
                require_once 'inc/login.php';
                $conn = new mysqli($hn, $un, $pw, $db);
                if ($conn->connect_error) 
                  die($conn->connect_error);
                  
                $bookID = '';
                
                if($_POST){ 
                  if(isset($_POST['delete'])){
                  $bookID = $_POST['delete'];
                    $query = "DELETE FROM nb_userCarts WHERE cartID = '" . $_SESSION['cart_id'] . "' AND bookID = '" . $bookID . "'";
                    $conn->query($query);
                  }
                }
                
                $query  = "SELECT I.title, I.ISBN, I.price, uC.isRent, I.bookID, uC.cartID FROM nb_Carts C, nb_userCarts uC, nb_Inventory I WHERE C.userID =" . $_SESSION['user_id'] . " AND uC.cartID = C.cartID AND uC.bookID = I.bookID ;";
                $result = $conn->query($query);

	              if ($result->num_rows < 1){
                  echo "There is nothing in the cart!";
                }
                
            	  else if ($result->num_rows)
            	  {
                    $total = "0";
                    $rows = $result->num_rows;
                    $SESSION_['cart_id'] = '';
                
                  echo "<table>
                        <tr>
                          <th>Title</th>
                          <th>ISBN</th>
                          <th>Buy/Rent</th>
                          <th>Price</th>
                          <th></th>
                        </tr>";
                        
                  for ($j = 0 ; $j < $rows ; ++$j)
                  {                     
                    $result->data_seek($j);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $isRent = "No";
                    if ($_SESSION['cart_id'] == '') $_SESSION['cart_id'] = $row['cart_id'];
                    if($row['isRent'] == 1)
                      $isRent = "Yes";
                    

                    echo '<tr><td>' . $row['title']   . '</td>';
                    echo '<td>'     . $row['ISBN']    . '</td>';
                    if($isRent == "Yes"){echo'<td> Rent </td>';}
                    else{echo'<td> Buy </td>';}
                    echo '<td>'     . $row['price']   . '</td>';
                    echo '<td><form action="cart.php" method="post">  
                        <button type="submit" class="btn btn-danger" name="delete" value= ' . $row['bookID'] . '>Delete</button> 
                      </form>
                    </td></tr>';
                    if($isRent == "Yes")
                    {
                      $total += 2;
                    }
                    elseif($isRent == "No")
                    {
                      $total += $row['price'];
                    }
                                                                                                                      
                    
                  }
                  echo("<tr><td><b>Total</b></td><td></td><td><b>" . $total . "</b></td></tr>");
                  echo'</table>';
                
                }
                
                $conn->close();                
                ?>
                
                
              <form action="checkout.php" method="post">  
                        <button type="submit" class="btn btn-dark" name="checkout" value= "checkout">Checkout</button> 
              </form>  
              
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