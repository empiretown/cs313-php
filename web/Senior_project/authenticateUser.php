<?php
// connect to the database
require_once('dbConnect.php');

// recieve the username and password
$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

// authenticate user credentials
$statement = $db->prepare("SELECT id, name, username, password
                           FROM account_holder
                           WHERE username = :username");
$statement->bindValue(":username", $username, PDO::PARAM_STR);
$statement->execute();

// get the password
$row = $statement->fetch(PDO::FETCH_ASSOC);
$passwordHashed = $row['password'];

// if login is succesful begin the session and head to the user profile
if(password_verify($password, $passwordHashed)){
  session_start();

  // get the rest of the variables
  $userId      = $row['id'];
  $name        = $row['name'];

  // set session variables
  $_SESSION["username"]     = $username;
  $_SESSION["userId"]       = $userId;
  $_SESSION["name"]         = $name;

  header("Location: userInterface.php");
}
else { // else we return to the login screen
  header("Location: login.php");
}

?>
