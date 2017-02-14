<?php
session_start();

$username = htmlspecialchars($_POST["usernameC"]);
$password = htmlspecialchars($_POST["passwordC"]);
$currency = 9000;

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

// Show the user data in the player table

$statement = $db->prepare("INSERT INTO player (username, password, currency) VALUES ('$username', '$password', $currency)");
$statement->execute();

header("Location: login.php");

?>
