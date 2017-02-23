<?php
session_start();
if (!isset($_SESSION["username"])) {
	header("Location: login.php"); /* Redirect browser */
	exit();
}
require_once('dbConnect.php');

$playerId = $_SESSION["playerId"];
$itemId = $_POST["itemId"];
$sellPrice = $_POST["price"];

// add the item to the sell board
$statement = $db->prepare("INSERT INTO userTOitems (player_id, item_id)
                           VALUES (:playerId, :itemId)");
$statement->bindValue(":playerId", $playerId, PDO::PARAM_INT);
$statement->bindValue(":itemId", $itemId, PDO::PARAM_INT);
$statement->execute();


// delete the relation between the sold item and the user
$statement = $db->prepare("DELETE FROM sellBoard
                           WHERE item_id = :itemId");
$statement->bindValue(":itemId", $itemId, PDO::PARAM_INT);
$statement->execute();

// still need to detract currency from the buyer
// and add the currency to the seller upon purchase
// but I want to handle all currency things within
// javascript so that I can handle the user attempting
// to go into debt as well as keep currency change
// related actions seperate from other processes

header("Location: sellBoard.php");
?>
