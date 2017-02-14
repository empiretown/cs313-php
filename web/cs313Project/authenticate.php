<?php

$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

session_start();

$_SESSION["user"] = $username;
//$_SESSION["currency"] = $userCurrency;

header("Location: dbInterface.php");

?>
