<!-- THIS PAGE IS PURELY FOR DATABASE VIEWING PURPOSES -->

<?php
session_start();
if (!isset($_SESSION["username"])) {
	header("Location: login.php"); /* Redirect browser */
	exit();
}
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
</head>

<body>
  <h1> CS313 Project Database</h1>

  <?php //connect to database

  require_once('dbConnect.php');

  echo "This is the dummy item data <br/>";
  // Show the dummy data in the item table
  $statement = $db->prepare("SELECT id, itemname, rarity FROM item");
  $statement->execute();

  // Go through each result
  while($row = $statement->fetch(PDO::FETCH_ASSOC))
  {
    $id = $row['id'];
    $name = $row['itemname'];
    $rarity = $row['rarity'];

    echo $id . " - " . $name . " - " . $rarity . "<br/>";
  }

  echo "<br/>";
  echo "This is the dummy player data <br/>";
  // Show the dummy data in the item table
  $statement2 = $db->prepare("SELECT id, username, password, currency FROM player");
  $statement2->execute();

  // Go through each result
  while($row2 = $statement2->fetch(PDO::FETCH_ASSOC))
  {
    $id2 = $row2['id'];
    $username = $row2['username'];
    $password = $row2['password'];
    $currency = $row2['currency'];

    echo $id2 . " - " . $username . " - " . $password . " - " . $currency . "<br/>";
  }

  $statement3 = $db->prepare("SELECT p.username, i.itemname, i.rarity FROM player p
                              INNER JOIN userTOitems u on p.id = u.player_id
                              INNER JOIN item i on u.item_id = i.id");
  $statement3->execute();

  echo "<br/>";
  echo "This is each players items data <br/>";
  echo "<table style='width:40%; border:1px solid black;'>";

  echo "<tr>";
  echo "<th> Username </th>";
  echo "<th> Item Name </th>";
  echo "<th> Item Rarity </th>";
  echo "</tr>";
  // Go through each result
  while($row3 = $statement3->fetch(PDO::FETCH_ASSOC))
  {
    $username = $row3['username'];
    $itemname = $row3['itemname'];
    $rarity = $row3['rarity'];

    echo "<tr>";
    echo "<td>" . $username . "</td>";
    echo "<td>" . $itemname . "</td>";
    echo "<td>" . $rarity . "</td>";
    echo "</tr>";
  }
  echo "</table>";

  ?>
  <br/><br/>
  <a href="logout.php">Logout</a>
</body>
</html>
