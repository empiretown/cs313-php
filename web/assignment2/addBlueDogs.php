<?php
session_start();

$count = $_SESSION["blueDogs"];
$count += 1;
$_SESSION["blueDogs"] = $count;

header("Location: store.php");

?>
