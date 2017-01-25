<?php
session_start();

$count = $_SESSION["redCats"];
$count -= 1;
if($count < 0) {
  $count = 0;
}
$_SESSION["redCats"] = $count;

header("Location: store.php");

?>
