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
                    $query = "DELETE FROM nb_usercarts WHERE cartID = '" . $_SESSION['cart_id'] . "' AND bookID = '" . $bookID . "'";
                    $conn->query($query);
                  }
                }
                
                $query  = "SELECT I.title, I.ISBN, I.price, uC.isRent, I.bookID, uC.cartID FROM nb_carts C, nb_usercarts uC, nb_inventory I WHERE C.userID =" . $_SESSION['user_id'] . " AND uC.cartID = C.cartID AND uC.bookID = I.bookID ;";
                $result = $conn->query($query);

	              if ($result->num_rows < 1){
                  echo "There is nothing in the cart!";
                }
                
            	  else if ($result->num_rows)
            	  {
                    $total = "0";
                    $rows = $result->num_rows;
                    $SESSION_['cart_id'] = '';
                ?>
                      <table id = 'cart_table' class="display compact" >
                        <thead>
                        <tr>
                          <th>Title</th>
                          <th>ISBN</th>
                          <th>Buy/Rent</th>
                          <th>Price</th>
                          <th class='no-sort'> </th>
                        </tr>
                        </thead>
                        <tbody>
                    <?php
                        
                  for ($j = 0 ; $j < $rows ; ++$j)
                  {                     
                    $result->data_seek($j);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $isRent = "No";
                    if ($_SESSION['cart_id'] == '') $_SESSION['cart_id'] = $row['cart_id'];
                    if($row['isRent'])
                      $isRent = "Yes";
                    ?>
                      <tr>
                        <td> <?php echo $row['title'] ?>  </td>
                        <td> <?php echo $row['ISBN'] ?> </td>
                        <td>
                          <?php
                            if($row['isRent']){
                              echo'Rent';
                            }
                            else{
                              echo'Buy';
                            } 
                          ?>
                        </td> 
                        <td>
                          $<?php
                            if($row['isRent']){
                              echo '2';
                            }
                            else{
                              echo $row['price'];
                            } 
                          ?>.00
                        </td>

                        <td>
                          <form action="cart.php" method="post">  
                            <button type="submit" class="btn btn-danger" name="delete" value= " <?php echo $row['bookID']  ?>">Delete</button> 
                          </form>
                        </td>
                      </tr>
                    <?php
                    if($isRent == "Yes")
                    {
                      $total += 2;
                    }
                    elseif($isRent == "No")
                    {
                      $total += $row['price'];
                    }
                  }
                  ?>
                      <tfoot>
                        <tr>
                          <td> </td>
                          <td> </td>
                          <td><b>Total</b></td>
                          <td><b> $<?php echo $total ?>.00 </b></td>
                          <td> </td>
                        </tr>
                      </tfoot>
                    </tbody>
                  </table>
                  <form action="checkout.php" method="post">  
                    <button type="submit" class="btn btn-dark" name="checkout" value= "checkout">Checkout</button> 
                  </form>  
                <?php
                }
                
                $conn->close();                
                ?>              
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
<script type="text/javascript">
        $(document).ready( function () {
          $('#cart_table').dataTable({
            "order": [],
          "columnDefs": [ {
          "targets"  : 'no-sort',
            "orderable": false,
            }]
          });
      } );
</script>