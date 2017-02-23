<?php
session_start();
if (!isset($_SESSION["username"])) {
	header("Location: login.php"); /* Redirect browser */
	exit();
}
require_once('dbConnect.php');

//$itemIdCheck = -1;
$username = $_SESSION["username"];
$playerId = $_SESSION["playerId"];
$currency = $_SESSION["currency"];
?>

<!DOCTYPE html>
<html>
<head>
  <?php
	  echo "<title>" . $username . "'s Homepage</title>";
  ?>
</head>

<body>

	<div style="text-align: center;">
		<br/><br/>

    <?php
      echo "<p> Welcome back " . $username . "</p>";
      echo "<p> You are member number: " . $playerId . "!</p>";
      echo "<p> You have " . $currency . " Brad Points</p>";

      echo "<br/> Your Items: ";
      echo "<table style='width:40%; border:1px solid black;'>";
      echo "<tr>";

      echo "<th> Item Name </th>";

      echo "<th> Item Name </th>";
      echo "<th> Item Rarity </th>";
      echo "<th> Attribute </th>";
      echo "<th> Value </th>";

      echo "<th> SELL </th>";
      echo "</tr>";

      $statement = $db->prepare("SELECT i.id, i.itemname, i.rarity, a.attribute, a.value
                                 FROM player p
                                 INNER JOIN userTOitems u on p.id = u.player_id
                                 INNER JOIN item i on u.item_id = i.id
                                 INNER JOIN itemAttributes a on i.id = a.item_id
                                 WHERE p.id = :playerId;");
      $statement->bindValue(":playerId", $playerId, PDO::PARAM_INT);
      $statement->execute();

      // Go through each result
      while($row = $statement->fetch(PDO::FETCH_ASSOC))
      {
        $itemId  = $row['id'];
        $itemname  = $row['itemname'];
        $rarity    = $row['rarity'];
        $attribute = $row['attribute'];
        $value = $row['value'];

      //  if($itemIdCheck != $itemId) {
          echo "<tr>";
          echo "<td>" . $itemId . "</td>";
          echo "<td>" . $itemname . "</td>";
          echo "<td>" . $rarity . "</td>";
          //$itemIdCheck = $itemId;
      //  }

        echo "<td>" . $attribute . "</td>";
        echo "<td>" . $value . "</td>";

          echo "<td>";
          echo "<form action='sellItem.php' method='post'>
                 <input type='hidden' name='itemId' value='$itemId'>
    	           <input type='text' name='sellPrice' placeholder='Enter Sell Price' required>
    		         <input type='submit' value='Sell Item'>
    		        </form>";
        echo "</td>";
        echo "</tr>";
      }
      echo "</table>";

    ?>
    <br/><br/>

    <form action="generateItem.php" method="post">
      <!--input type="hidden" name="userId"><br/><br/-->
      <input type="submit" value="Gamble for a new item!">
    </form>
    <br/><br/>

    <a href="dbInterface.php">Show me the whole Database</a>
    <br/>
    <a href="SellBoard.php">Show me the SellBoard</a>
    <br/>
    <a href="logout.php">Logout</a>
	</div>
</body>
</html>
