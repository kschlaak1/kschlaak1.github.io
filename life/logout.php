<?php
session_start();
$_SESSION = array();//reset all variables
session_destroy();
header("location: login.php");
exit;
?>
