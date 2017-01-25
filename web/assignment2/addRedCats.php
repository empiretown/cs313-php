<?php
session_start();

$count = $_SESSION["redCats"];
$count += 1;
$_SESSION["redCats"] = $count;

header("Location: store.php");

?>
