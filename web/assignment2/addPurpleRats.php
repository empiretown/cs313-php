<?php
session_start();

$count = $_SESSION["purpleRats"];
$count += 1;
$_SESSION["purpleRats"] = $count;

header("Location: store.php");

?>
