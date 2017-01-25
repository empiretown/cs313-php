<?php
session_start();

$count = $_SESSION["yellowOwls"];
$count -= 1;
if($count < 0) {
  $count = 0;
}
$_SESSION["yellowOwls"] = $count;

header("Location: store.php");

?>
