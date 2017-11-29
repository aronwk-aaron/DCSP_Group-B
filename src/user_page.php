<?php
	require_once("templates/header.php");
	if(isset($_SESSION['username'])){
		if($is_admin){
		  header("Location: admin_page.php" );
		  exit();
		}
		else{
            require_once 'inc/login.php';
            $conn = new mysqli($hn, $un, $pw, $db);
            if ($conn->connect_error)
                die($conn->connect_error);

            //$_SESSION['userID'];
            $userName = $_SESSION['username'];
            $userID = $_SESSION['user_id'];
            //$_SESSION['userID'];

            $query  = "SELECT I.isbn, I.price, H.orderNum, uH.datePurch, uH.dueDate, I.title FROM nb_userhistory uH, nb_history H, nb_inventory I WHERE H.userID = $userID AND uH.orderNum = H.orderNum AND uH.bookID = I.bookID";
            $result = $conn->query($query);
            if (!$result)
                die($conn->error);
            $rows = $result->num_rows;
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
                        <div class="container">
                            </br>
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Purchase History</h3>
                                    <table id="history_table" class="display compact" >
                                        <thead>
                                        <tr>
                                            <th>  Order Number             </th>
                                            <th>  Title                    </th>
                                            <th>  ISBN                     </th>
                                            <th>  Price                    </th>
                                            <th>  Date Purchased           </th>
                                            <th>  Date Due                 </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        //table display
                                        for ($j = 0 ; $j < $rows ; ++$j)
                                        {
                                        $result->data_seek($j);
                                        $row = $result->fetch_array(MYSQLI_ASSOC);
                                        ?>
                                        <tr>
                                            <td>      <?php print($row['orderNum']);   ?>     </td>
                                            <td>      <?php print($row['title']) ?></td>
                                            <td>      <?php print($row['isbn']);       ?>     </td>
                                            <td>      $<?php print($row['price']);     ?>.00  </td>
                                            <td>      <?php print($row['datePurch']);  ?>     </td>

                                            <?php
                                            if($row['dueDate'] == "0000-00-00") {
                                                ?>
                                                <td> No Due Date</td>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <td>     
                                                    <?php  
                                                        if ($row['dueDate'] != '0000-00-00') {
                                                            print($row['dueDate']); 
                                                        }
                                                    ?>     
                                                </td>
                                                <?php
                                            }
                                        }
                                            ?></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
<script type="text/javascript">
        $(document).ready( function () {
          $('#history_table').dataTable({
            "order": [],
          "columnDefs": [ {
          "targets"  : 'no-sort',
            "orderable": false,
            }]
          });
      } );
</script>