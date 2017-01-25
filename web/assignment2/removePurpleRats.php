<?php
session_start();

$count = $_SESSION["purpleRats"];
$count -= 1;
if($count < 0) {
  $count = 0;
}
$_SESSION["purpleRats"] = $count;

header("Location: store.php");

?>
