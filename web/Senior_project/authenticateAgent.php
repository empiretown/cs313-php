<?php
// connect to the database
require_once('dbconnect.php');

// recieve the username and password
$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

// authenticate user credentials
$statement = $db->prepare("SELECT id, employee_num, firstName, lastName, username, password
                           FROM bank_agent
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
  $bankerId      = $row['id'];
  $employee_num  = $row['employee_num'];
  $firstName     = $row['firstName'];
  $lastName      = $row['lastName'];

  // set session variables
  $_SESSION["username"]     = $username;
  $_SESSION["bankerId"]     = $bankerId;
  $_SESSION["employee_num"] = $employee_num;
  $_SESSION["firstName"]    = $firstName;
  $_SESSION["lastName"]     = $lastName;

  header("Location: bankInterface.php");
}
else { // else we return to the login screen
  header("Location: login.php");
}

?>
