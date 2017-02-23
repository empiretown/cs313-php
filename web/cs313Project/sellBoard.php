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
  <title>Item Sellboard</title>

</head>

<body>

	<div style="text-align: center;">
		<br/><br/>

    <?php
      echo "<p>" . $username . ", you have " . $currency . " Brad Points left to spend</p>";

      echo "<br/> Items for sale: ";
      echo "<table style='width:40%; border:1px solid black;'>";
      echo "<tr>";
      echo "<th> Item Name </th>";
      echo "<th> Item Rarity </th>";
      //echo "<th> Attribute </th>";
      echo "<th> Price </th>";

      echo "<th> BUY </th>";
      echo "</tr>";

      $statement = $db->prepare("SELECT i.itemname, i.rarity, s.item_id, s.price
                                 FROM sellBoard s
                                 INNER JOIN item i on s.item_id = i.id");
                                 //INNER JOIN itemAttributes a on i.id = a.item_id");
      $statement->execute();

      // Go through each result
      while($row = $statement->fetch(PDO::FETCH_ASSOC))
      {
        $itemname  = $row['itemname'];
        $rarity    = $row['rarity'];
        $itemId    = $row['item_id'];
        //$attribute = $row['attribute'];
        $price = $row['price'];

      //  if($itemIdCheck != $itemId) {
          echo "<tr>";
          echo "<td>" . $itemname . "</td>";
          echo "<td>" . $rarity . "</td>";
          //$itemIdCheck = $itemId;
      //  }

        //echo "<td>" . $attribute . "</td>";
        echo "<td>" . $price . "</td>";

          echo "<td>";
          echo "<form action='buyItem.php' method='post'>
                 <input type='hidden' name='itemId' value='$itemId'>
                 <input type='hidden' name='price' value='$price'>
    		         <input type='submit' value='Buy Item'>
    		        </form>";
        echo "</td>";
        echo "</tr>";
      }
      echo "</table>";

    ?>
    <br/><br/>

    <a href="userInterface.php">Show me the userInterface</a>
    <br/>
    <a href="dbInterface.php">Show me the whole Database</a>
    <br/>
    <a href="logout.php">Logout</a>
	</div>
</body>
</html>
