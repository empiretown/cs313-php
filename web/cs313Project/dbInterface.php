<!DOCTYPE html>
<html>
<head>
</head>

<body>
  <h1> CS313 Project </h1>

  <?php //connect to database

  // variables
  $dbUser = 'brother_burton';
  $dbPassword = 'bradismyfavoritestudent';
  $dbName = 'postgres';
  $dbHost = 'localhost';
  $dbPort = '5432';

  try
  {
    // create pdo connection
    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
  } catch (PDOException $ex)
  {
    // print the error
    echo "Error connecting to DB. Details: $ex";
    die();
  }

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

  ?>
