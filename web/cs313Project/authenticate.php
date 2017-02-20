<?php
// connect to the database
require_once('dbConnect.php');

// recieve the username and password
$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

// authenticate user credentials
$statement = $db->prepare("SELECT id, password, currency FROM player
                           WHERE username = :username");
$statement->bindValue(":username", $username, PDO::PARAM_STR);
$statement->execute();

// get the password
$row = $statement->fetch(PDO::FETCH_ASSOC);
$passwordHashed = $row['password'];
$playerId       = $row['id'];
$currency       = $row['currency'];

// if login is succesful begin the session and head to the user profile
if(password_verify($password, $passwordHashed)){
  session_start();
  $_SESSION["username"] = $username;
  $_SESSION["playerId"] = $playerId;
  $_SESSION["currency"] = $currency;

  header("Location: userInterface.php");
}
else { // else we return to the login screen
  header("Location: login.php");
}

?>
