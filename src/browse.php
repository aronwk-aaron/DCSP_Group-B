<?php
	require_once("templates/header.php");
?>

<div class="container">
</br>
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Browse and Search</h3>

    	<?php
     //query for all inventory
          
        //database query section
      require_once 'inc/login.php';
      $conn = new mysqli($hn, $un, $pw, $db);
      if ($conn->connect_error) 
        die($conn->connect_error);

      $query  = "SELECT isbn, title, author, publisher, genre, price, quantity, inStock FROM nb_Inventory";

      $result = $conn->query($query);
      if (!$result) 
        die($conn->error);

      $rows = $result->num_rows;
      ?>
      <table id="table_id" class="display compact" >
      <thead>
            <tr>
              <th>  Title             </th>
              <th>  Author            </th>
              <th>  Genre             </th> 
              <th>  ISBN              </th>
              <th>  Publisher         </th>
              <th>  Price             </th>
              <th>  Quantity          </th>
              <th>  In Stock          </th>
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
        $inStock = "No";
        if($row['inStock'] == 1)
          $inStock = "Yes";
        
        ?>
        <tr>
          <td>      <?php print($row['title']);      ?>      </td>
          <td>      <?php print($row['author'] );    ?>      </td>
          <td>      <?php print($row['genre']);      ?>      </td>
          <td>      <?php print($row['isbn']);       ?>      </td>
          <td>      <?php print($row['publisher']);  ?>      </td>
          <td>     $<?php print($row['price']);      ?>.00   </td>
          <td>      <?php print($row['quantity']);   ?>      </td>
          <td>      <?php print($inStock)            ?>      </td>

        <?php
        if($is_user){
          ?>
            <td>  
              <button type="button" class="btn btn-success">Buy</button> <button type="button" class="btn btn-warning">Rent</button>
            </td>
          <?php
        }
      }
      
      ?></tbody>
      </table>
    </div>
  </div>
</div>
<?php
	$pageTitle = 'Browse';
	require_once("templates/footer.php");

?>