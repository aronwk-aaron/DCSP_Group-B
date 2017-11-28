<?php
	require_once("templates/header.php");
?>
<script type="text/javascript">
  var page_title = "NetBooks - Browse";
</script>

<div class="container">
</br>
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Browse and Search</h3>
      <?php
        if($_POST)
        {
          require_once 'inc/login.php';
          $conn = new mysqli($hn, $un, $pw, $db);
          if ($conn->connect_error) 
            die($conn->connect_error);
          
          $isRent = '';
          if(isset($_POST['buy']))
            $sqlCheck = "SELECT isRent FROM nb_usercarts WHERE bookID = '" . $_POST['buy'] . "' && cartID = '" . $_SESSION['user_id'] . "'";
          
          if(isset($_POST['rent']))
            $sqlCheck = "SELECT isRent FROM nb_usercarts WHERE bookID = '" . $_POST['rent'] . "' && cartID = '" . $_SESSION['user_id'] . "'";
          
          $results = $conn->query($sqlCheck);
          while($result = mysqli_fetch_assoc($results)) 
          { 
            $isRent = $result['isRent'];
          }
          
          if($isRent == '0' && isset($_POST['buy']))
          {
            echo('<span style="color:red;font-weight:bold;text-align:center;">');
            echo("<i>" . $_POST['title'] . "</i>");
            echo(" is already in the cart to purchase.");
            echo("</span>");
          }
          
          elseif($isRent == '0' && isset($_POST['rent']))
          {
            $sqlChange = "UPDATE nb_usercarts
            SET isRent = '1' WHERE bookID = '" . $_POST['rent'] . "' && cartID = '" . $_SESSION['user_id'] . "'";
            if($conn->query($sqlChange) === True)
            {
              echo('<span style="color:orange;font-weight:bold;text-align:center;">');
              echo("<i>" . $_POST['title'] . "</i>");
              echo(" was updated in the cart from purchase to rent.");
              echo('</span>');
            }
          }
          
          elseif($isRent == '1' && isset($_POST['rent']))
          {
            echo('<span style="color:red;font-weight:bold;text-align:center;">');
            echo("<i>" . $_POST['title'] . "</i>");
            echo(" is already in the cart to rent.");
            echo("</span>");
          }
          
          elseif($isRent == '1' && isset($_POST['buy']))
          {
            $sqlChange = "UPDATE nb_usercarts
            SET isRent = '0' WHERE bookID = '" . $_POST['buy'] . "' && cartID = '" . $_SESSION['user_id'] . "'";
            if($conn->query($sqlChange) === True)
            {
              echo('<span style="color:green;font-weight:bold;text-align:center;">');
              echo("<i>" . $_POST['title'] . "</i>");
              echo(" was updated in the cart from rent to purchase.");
              echo('</span>');
            }
          }
          
          elseif(isset($_POST['buy']))
          {
            $sql = "INSERT INTO nb_usercarts(cartID, bookID, isRent)
              VALUES ('" . $_SESSION['user_id'] . "', '" . $_POST['buy'] . "', '0')";
            if($conn->query($sql) === TRUE)
            {
              echo('<span style="color:green;font-weight:bold;text-align:center;">');
              echo("<i>" . $_POST['title'] . "</i>");
              echo(" was successfully added to the cart to purchase.");
              echo('</span>');
            }
          }
          
          elseif(isset($_POST['rent']))
          {
            $sql = "INSERT INTO nb_usercarts(cartID, bookID, isRent)
              VALUES ('" . $_SESSION['user_id'] . "', '" . $_POST['rent'] . "', '1')";
            if($conn->query($sql) === TRUE)
            {
              echo('<span style="color:orange;font-weight:bold;text-align:center;">');
              echo("<i>" . $_POST['title'] . "</i>");
              echo(" was successfully added to the cart to rent.");
              echo('</span>');
            }
          }         
        }

?>

    	<?php
     //query for all inventory
          
        //database query section
      require_once 'inc/login.php';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) 
        die($conn->connect_error);

      $query  = "SELECT * FROM nb_inventory";

      $result = $conn->query($query);
      if (!$result) 
        die($conn->error);

      $rows = $result->num_rows;
      ?>
      <table id="browse_table" class="display compact" >
      <thead>
            <tr>
              <th>  Title     </th>
              <th>  Author    </th>
              <th>  Genre     </th> 
              <th>  ISBN      </th>
              <th>  Publisher </th>
              <th>  Price     </th>
              <!-- <th>  Quantity  </th> -->
              <?php 
              if($is_user){
              ?>
                <th class="no-sort">  Purchase Option   </th>
              <?php
              }
              ?>

            </tr>
          </thead>
          <tbody>
      <?php
        
      //table display
      for ($j = 0 ; $j < $rows ; ++$j)
      {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($row['inStock']){
        
          ?>
          <tr>
            <td>      <?php print($row['title']);      ?>      </td>
            <td>      <?php print($row['author'] );    ?>      </td>
            <td>      <?php print($row['genre']);      ?>      </td>
            <td>      <?php print($row['isbn']);       ?>      </td>
            <td>      <?php print($row['publisher']);  ?>      </td>
            <td>     $<?php print($row['price']);      ?>.00   </td>
            <!-- <td>      <?php print($row['quantity']);   ?>      </td> -->
          <?php
          if($is_user){
            ?>
              <td>
              <form action="browse.php" method="post">
                <input type=hidden name="title" value="<?php echo($row['title']);?>">  
                <button type="submit" class="btn btn-success" name="buy" value="<?php echo($row['bookID']);?>">Buy</button> 
                <button type="submit" class="btn btn-warning" name="rent" value="<?php echo($row['bookID']);?>">Rent</button>
              </form>
              </td>
            <?php
          }
        }
      }
      
      ?></tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready( function () {
    $('#browse_table').dataTable({
      "order": [],
    "columnDefs": [ {
    "targets"  : 'no-sort',
      "orderable": false,
      }]
    });
  } );
</script>
<?php
	require_once("templates/footer.php");
  $conn->close();
?>