<?php
require_once("templates/header.php");
//kicking out the wrong peopl
if(isset($_SESSION['username'])){
    if(!$is_admin){
        header("Location: user_page.php" );
        exit();
    }
}
$err_msg = "";

$title = $isbn = $author = $genre = $publisher = $price = $quantity = $incomplete = $error = $successful = $isbnDupe = $invalidInput = $negativeErr = $isbnLenErr = "";

if($_POST)
{
    $isbn = sanitizeString($_POST['isbn']);
    $title = ($_POST['title']);
    $genre = $_POST['genre'];
    $author = ($_POST['author']);
    $publisher = $_POST['publisher'];
    $quantity = sanitizeNum($_POST['quantity']);
    $price = sanitizeNum($_POST['price']);

    if($isbn != $_POST['isbn'] || $title != $_POST['title'] || $author != $_POST['author'] || $publisher != $_POST['publisher'] || $price != $_POST['price'] || $quantity != $_POST['quantity'] || $genre != $_POST['genre'])
    {
        $invalidInput = "True";
        $error = "True";
    }

    if(strlen($isbn) > 13)
    {
        $isbnLenErr = "True";
        $error = "True";
    }

    if(($price) <= 0 || ($quantity <= 0))
    {
        $negativeErr = "True";
        $error = "True";
    }

    if($_POST && (!$title || !$isbn || !$author || !$publisher || $genre =="Choose Genre" || !$price || !$quantity))
    {
        $incomplete = "1";
    }

    else
    {
        $incomplete = "";
    }

    require_once 'inc/login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error)
        die($conn->connect_error);

    $results = $conn->query("SELECT isbn FROM nb_inventory");
    while($result = mysqli_fetch_assoc($results))
    {
        if($isbn == $result['isbn'])
        {
            $error = "True";
            $isbnDupe = "True";
            break;
        }
    }

    if(!isset($_POST['confirm']))
    {
        $error = "True";
    }

    if(!$error && !$incomplete)
    {
        $sql = "INSERT INTO nb_inventory(isbn, title, author, publisher, genre, price, quantity, inStock)
      VALUES ('" . $isbn . "', '" . $title . "', '" . $author . "', '" . $publisher . "', '" . $genre . "', '" . $price . "', '" . $quantity . "', 'true')";

        if(!$conn->query($sql))
        {
            echo("<h1>Error adding book.</h1>");
        }
        else
        {
            $successful = "True";
        }
    }

    $conn->close();
}


function sanitizeString($var)
{
    return preg_replace('/[^A-Za-z0-9\-]/', '', $var);
}

function sanitizeNum($var)
{
    return preg_replace('/[^0-9]/', '', $var);
}

?>
    <script type="text/javascript">
        var page_title = "NetBooks - Add book";
    </script>
    <div class="container">
        <br>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> Add Book: </h3>
                <span style="color:blue;font-weight:bold;text-align:center;">
      <?php if($successful) {echo('Book successfully added!');}?>
      </span>
                <style>
                    .error {color: #FF0000;}
                </style>
                <p><span class="error">
        <?php if($incomplete) {echo('All form fields must be completed to a book to NetBooks.</br>');}
        if($invalidInput) {echo('Invalid special characters deleted. Check fields and resubmit.');}?>
      </span></p>
                <form method="post" action="add_book.php">
                    <p class="card-text" style="color: red">
                        <?php echo $err_msg; ?>
                    </p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputISBN">ISBN</label>
                            <span class="error"><?php if($isbnDupe) {echo('This isbn already exists in library.');}?>
              </span>
                            <input type="text" name="isbn" class="form-control" id="inputISBN" <?php if(!$_POST || ($_POST && !$isbn)) {echo('placeholder="ISBN"');}
                            else {echo('value='); echo($isbn);}?>>
                            <span class="error"><?php if($isbnLenErr) {echo('Please use a 13 digit ISBN code.');}?>
                            </span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputTitle">Title</label>
                            <input type="text" name="title" class="form-control" id="inputTitle" <?php if(!$_POST || ($_POST && !$title)) {echo('placeholder="Title"');}
                            else {echo('value='); echo($title);}?>>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAuthor">Author</label>
                            <input type="text" name="author" class="form-control" id="inputAuthor" <?php if(!$_POST || ($_POST && !$author)) {echo('placeholder="Author"');}
                            else {echo('value='); echo($author);}?>>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPublisher">Publisher</label>
                            <input type="text" name="publisher" class="form-control" id="inputPublisher" <?php if(!$_POST || ($_POST && !$publisher)) {echo('placeholder="Publisher"');}
                            else {echo('value='); echo($publisher);}?>>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputGenre">Genre</label>
                            <select id="inputGenre" name="genre" class="form-control">
                                <?php if(!$_POST || ($_POST && $genre =="Choose Genre")) {echo('<option selected>Choose Genre</option>');}
                                else {echo('<option selected>'); echo($genre); echo('</option>');}?>
                                <option value="Non-Fiction">Non-Fiction</option>
                                <option value="Fiction">Fiction</option>
                                <option value="Educational">Educational</option>
                                <option value="Play">Play</option>
                                <option value="Romance">Romance</option>
                                <option value="Fantasy">Fantasy</option>
                                <option value="Science-Fiction">Science-Fiction</option>
                                <option value="Autobiography">Autobiography</option>
                                <option value="Horror">Horror</option>
                                <option value="Adventure">Adventure</option>
                                <option value="Cookbook">Cookbook</option>
                                <option value="Religion">Religion</option>
                                <option value="Action and Adventure">Action and Adventure</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputPrice">Price</label>
                            <input type="text" name="price" class="form-control" id="inputPrice" <?php if(!$_POST || ($_POST && !$price)) {echo('placeholder="15"');}
                            else {echo('value='); echo($price);}?>>
                            <span class="error"><?php if($negativeErr) {echo('Please enter a number above 0.');}?>
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputQuantity">Quantity</label>
                            <input type="text" name="quantity" class="form-control" id="inputQuantity" <?php if(!$_POST || ($_POST && !$quantity)) {echo('placeholder="10"');}
                            else {echo('value='); echo($quantity);}?>>
                            <span class="error"><?php if($negativeErr) {echo('Please enter a number above 0.');}?>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="confirm" value="True"> Confirm
                                <span class="error">
                  <?php if($_POST && !isset($_POST['confirm'])) {echo("Check the box to confirm your submission and click 'Add Book'");}?>
                </span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark">Add book</button>
                </form>
            </div>
        </div>
    </div>

<?php
require_once("templates/footer.php");
?>