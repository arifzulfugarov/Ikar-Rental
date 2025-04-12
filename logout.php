<?php
//I am destroying the session and redirecting the user to the login page

session_start();

session_destroy();

header('Location: login.php');
exit();

?>