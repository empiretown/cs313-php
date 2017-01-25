<?php
session_start();

$count = $_SESSION["blueDogs"];
$count -= 1;
if($count < 0) {
  $count = 0;
}
$_SESSION["blueDogs"] = $count;

header("Location: store.php");

?>
