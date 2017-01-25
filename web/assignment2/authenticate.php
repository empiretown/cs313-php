<?php

$username = htmlspecialchars($_POST["username"]);
$count = 0;

session_start();

$_SESSION["user"] = $username;
$_SESSION["redCats"] = $count;
$_SESSION["blueDogs"] = $count;
$_SESSION["yellowOwls"] = $count;
$_SESSION["purpleRats"] = $count;

header("Location: store.php");

?>
