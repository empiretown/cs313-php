<?php
session_start();
if (!isset($_SESSION["username"])) {
	header("Location: login.php"); /* Redirect browser */
	exit();
}
require_once('dbConnect.php');

//$itemIdCheck = -1;
$username     = $_SESSION["username"];
$bankerId     = $_SESSION["bankerId"];
$employee_num = $_SESSION["employee_num"];
$firstName    = $_SESSION["firstName"];
$lastName     = $_SESSION["lastName"];

?>

<!DOCTYPE html>
<html>
<head>
  <?php
	  echo "<title>" . $firstName . "'s Interface</title>";
  ?>
</head>

<body>

	<div style="text-align: center;">
		<br/><br/>

    <?php
      echo "<p> Welcome back " . $firstName . " " . $lastName . "</p>";
      echo "<p> Your employee number is: " . $employee_num . "</p>";
      echo "<p> Make sure to work hard today!</p>";

      echo "<br/> Pending Deposits: ";
      echo "<table style='width:40%; border:1px solid black;'>";

      echo "<tr>";
      echo "<th> Deposit ID </th>";
      echo "<th> Account Holder ID </th>";
      echo "<th> Bank Account </th>";
      echo "<th> Deposit Amount </th>";
      echo "<th> Check Front </th>";
      echo "<th> Check Back </th>";
      echo "</tr>";

      $statement = $db->prepare("SELECT id, account_holder_id, bank_account,
																			  deposit_amount, check_front, check_back
                                 FROM pending_deposit");
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

    <a href="dbInterface.php">Show me the whole Database</a>
    <br/>

    <a href="logout.php">Logout</a>
	</div>
</body>
</html>
