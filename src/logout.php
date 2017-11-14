<?php
	session_start();
	$_SESSION = array();
    if (isset($_SESSION['username'])){
        setcookie(session_name(),'',time()-999999);
    }
    session_destroy();
	require_once("templates/header.php");
    // remove session and session cookie
?>

<div class="container">
	You are now Logged out.
</div>

<?php
	$pageTitle = 'Logout';
	require_once("templates/footer.php");
?>