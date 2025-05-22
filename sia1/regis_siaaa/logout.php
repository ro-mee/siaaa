<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page (you can change this to your login page)
header("Location: login.php");
exit();
?> 