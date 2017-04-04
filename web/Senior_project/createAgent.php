<?php
  session_start();

  $firstName = htmlspecialchars($_POST["firstName"]);
  $lastName  = htmlspecialchars($_POST["lastName"]);
  $username  = htmlspecialchars($_POST["usernameC"]);
  $password  = htmlspecialchars($_POST["passwordC"]);
  $password2 = htmlspecialchars($_POST["passwordC2"]);

  if (strcmp($password, $password2) == 0) {

    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
    require_once('dbconnect.php');

    // Insert the user data in the player table
    $statement = $db->prepare("INSERT INTO bank_agent (firstName, lastName, username, password)
                               VALUES (:firstName, :lastName, :username, :passwordHashed)");
    $statement->bindValue(":firstName", $firstName, PDO::PARAM_STR);
    $statement->bindValue(":lastName", $lastName, PDO::PARAM_STR);
    $statement->bindValue(":username", $username, PDO::PARAM_STR);
    $statement->bindValue(":passwordHashed", $passwordHashed, PDO::PARAM_STR);
    $statement->execute();
  }
  else {
  }
  header("Location: login.php");

?>
