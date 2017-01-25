<?php
session_start();

$count = $_SESSION["yellowOwls"];
$count += 1;
$_SESSION["yellowOwls"] = $count;

header("Location: store.php");

?>
