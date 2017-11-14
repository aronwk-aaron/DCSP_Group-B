<?php
	require_once("templates/header.php");
?>

<div class="container">
	<?php
browse();
  
function browse()
  {
    //performs query for all inventory
      
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
      
    echo'<table>';
    echo'<tr><th>Author</th><th>Title</th><th>Genre</th><th>ISBN</th><th>Publisher</th><th>Price</th><th>Quantity</th><th>In Stock</th></tr>';
      
    //table display
    for ($j = 0 ; $j < $rows ; ++$j)
    {
      $result->data_seek($j);
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $inStock = "No";
      if($row['inStock'] == 1)
        $inStock = "Yes";
      

      echo '<tr><td>' . $row['author']    . '</td>';
      echo '<td>'     . $row['title']     . '</td>';
      echo '<td>'     . $row['genre']     . '</td>';
      echo '<td>'     . $row['isbn']      . '</td>';
      echo '<td>'     . $row['publisher'] . '</td>';
      echo '<td>'     . $row['price']     . '</td>';
      echo '<td>'     . $row['quantity']  . '</td>';
      echo '<td>'     . $inStock          . '</td></tr>';
    }
    
    echo'</table>';
  }
?>
</div>

<?php
	$pageTitle = 'Browse';
	require_once("templates/footer.php");

?>