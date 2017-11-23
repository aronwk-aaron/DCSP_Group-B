<?php
	session_start();
	$_SESSION = array();
    if (isset($_SESSION['username'])){
        setcookie(session_name(),'',time()-999999);
        session_destroy();
    }
    else{
    	header("Location: index.php");
    }
	require_once("templates/header.php");
    // remove session and session cookie
?>
<script type="text/javascript">
	var page_title = "NetBooks - Logout";
</script>
<div class="container">
	You are now Logged out.
</div>

<?php
	require_once("templates/footer.php");
?>