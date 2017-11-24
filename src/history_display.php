<?php
require_once("templates/header.php");
$is_user = false;
$is_admin = false;
// Is this an admin?
if(isset($_SESSION['username'])) {
    if ($_SESSION['isAdmin']) {
        $is_admin = true;
    } else {
        $is_user = true;
    }
}
//query user History table
require_once 'inc/login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error)
    die($conn->connect_error);

//$_SESSION['userID'];
$userName = $_SESSION['username'];
$userID = "SELECT userID FROM nb_userstable WHERE userName = '$userName'";
$result = $conn->query($userID);
$userID = $result->num_rows;
//$_SESSION['userID'];

if($is_user == true)
    $query  = "SELECT I.isbn, I.price, H.orderNum, uH.datePurch, uH.dueDate FROM nb_userHistory uH, nb_History H, nb_Inventory I WHERE H.userID = $userID AND uH.orderNum = H.orderNum AND uH.bookID = I.bookID";
else
    $query  = "SELECT I.isbn, I.price, H.orderNum, uH.datePurch, uH.dueDate, uT.username  FROM nb_userHistory uH, nb_History H, nb_Inventory I, nb_userstable uT WHERE H.userID = uT.userID AND uH.orderNum = H.orderNum AND uH.bookID = I.bookID";

$result = $conn->query($query);
      if (!$result)
          die($conn->error);
$rows = $result->num_rows;
?>

<div class="container">
</br>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Purchase History</h3>
            <table id="table_id" class="display compact" >
                <thead>
                <tr>
                    <th>  Order Number             </th>
                    <th>  ISBN                     </th>
                    <th>  Price                    </th>
                    <th>  Date Purchased           </th>
                    <th>  Date Due                 </th>
                    <?php
                    if($is_admin){
                        ?>
                        <th>  User ID   </th>
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
            ?>
                <tr>
                <td>      <?php print($row['orderNum']);   ?>     </td>
                <td>      <?php print($row['isbn']);       ?>     </td>
                <td>      $<?php print($row['price']);     ?>.00  </td>
                <td>      <?php print($row['datePurch']);  ?>     </td>

                <?php
                if($row['dueDate'] == NULL) {
                    ?>
                    <td> No Due Date</td>
                    <?php
                }
                else{
                    ?>
                    <td>     <?php print($row['dueDate']); ?>     </td>
                    <?php
                }
                if($is_admin){
                    ?>
                    <td>
                        <?php print($row['username']);     ?>
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
    <div><ul><li><a href="user_page.php">Back to Profile</a></li></ul></div>
    <?php
    $pageTitle = 'History';
    require_once("templates/footer.php");

    ?>