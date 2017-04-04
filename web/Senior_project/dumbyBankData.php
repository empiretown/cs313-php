
<?php
session_start();

require_once('dbConnect.php');

$firstName = "dumby data";
?>

<!DOCTYPE html>
<html>
<head>
  <?php
	  echo "<title>" . $firstName . "'s Interface</title>";
  ?>
</head>

<body>
		<br/><br/>
    <?php
      echo "<br/> Megan's Bank Account: ";

      echo "<table style='width:40%; border:1px solid black;'>";

      echo "<tr>";
      echo "<th> name </th>";
      echo "<th> accNum </th>";
      echo "<th> accAmount</th>";
      echo "<th> transaction_history_id </th>";
      echo "</tr>";

      $one = 1;

      $statement = $db->prepare("SELECT a.name, b.account_num, b.account_amount
                                 FROM account_holder a
                                 INNER JOIN account_holder_to_bank_account t on a.id = t.account_holder_id
                                 INNER JOIN bank_account b on t.bank_account_id  = b.id
                                 WHERE a.id = :one;");
      $statement->bindValue(":one", $one, PDO::PARAM_INT);
      $statement->execute();

      // Go through each result
      while($row = $statement->fetch(PDO::FETCH_ASSOC))
      {
        $name      = $row['name'];
        $accNum    = $row['account_num'];
        $accAmount = $row['account_amount'];
        $transID   = $row['transaction_history_id'];

        echo "<tr>";
        echo "<td>" . $name . "</td>";
        echo "<td>" . $accNum . "</td>";
        echo "<td>" . $accAmount . "</td>";
        echo "<td>" . $transID . "</td>";

        echo "</tr>";
      }
      echo "</table>";

    ?>
    <br/><br/>

</body>
</html>
