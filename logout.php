<?php
session_start();

/*
 Step 1: Remove all session variables
*/
$_SESSION = [];

/*
 Step 2: Destroy session completely
*/
session_destroy();

/*
 Step 3: Redirect to login page
*/
header("Location: index.php");
exit();
?>