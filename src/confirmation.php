<?php
	require_once("templates/header.php");
  if(!isset($_SESSION['total']))
  {
    header("Location: index.php");
  }
  
  if(!isset($_SESSION['username']))
  {
    header("Location: login_page.php");
  }
	if(isset($_SESSION['username']))
  {
		if($is_admin)
    {
		  header("Location: admin_page.php" );
		  exit();
		}
?>

  <script type="text/javascript">
  var page_title = "NetBooks - Confirmation";
</script>
<div class="container">
	<br>
	<div class="card">
		<div class="card-body">
			<h3 class="card-title"> Confirmation </h3>
      <h5>Thank you for your purchase <?php echo($_SESSION['firstname']); ?>!</h5>
      <h5>Here is your order</h5>
      <p><b>Order Total: </b>$<?php echo($_SESSION['total']); ?>.00 </p>
      <table id="purchase" class="display compact" >
      <thead>
            <tr>
              <th>  Title          </th>
              <th>  Return Date    </th>
            </tr>
      </thead>
      <tbody>
      <?php
      $books = $_SESSION['books'];
      $returnDates = $_SESSION['returnDates'];
      for ($j = 0 ; $j < count($books) ; ++$j)
      {        
      ?>
          <tr>
            <td>      <?php print($books[$j]); ?>        </td>
            <?php
            if($returnDates[$j] == "0000-00-00")
            {
            ?>
              <td>    No Due Date                        </td>
            <?php
            }
            else
            {  
            ?> 
              <td>    <?php print($returnDates[$j]); ?>  </td>
            <?php
             }
            ?>
          </tr>
      <?php
      }
      ?>
      </tbody>
      
    </div>
  </div>      
</div>

<?php
      
	require_once("templates/footer.php");
}
?>

<script type= "text/javascript"> 
$(document).ready( function () {
    			$('#purchase').dataTable({
    				"order": [],
					"columnDefs": [ {
					"targets"  : 'no-sort',
				    "orderable": false,
				    }]
    			});
			} );
</script>

<?php
  unset($_SESSION['books']);
  unset($_SESSION['returnDates']);
  unset($_SESSION['total']); 
?>