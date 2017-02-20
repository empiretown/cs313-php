<?php
  session_start();

  $username = htmlspecialchars($_POST["usernameC"]);
  $password = htmlspecialchars($_POST["passwordC"]);
  $password2 = htmlspecialchars($_POST["passwordC2"]);
  $currency = 9000;

  if (strcmp($password, $password2) == 0) {

    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
    require_once('dbConnect.php');

    // Insert the user data in the player table
    $statement = $db->prepare("INSERT INTO player (username, password, currency)
                               VALUES (:username, :passwordHashed, :currency)");
    $statement->bindValue(":username", $username, PDO::PARAM_STR);
    $statement->bindValue(":passwordHashed", $passwordHashed, PDO::PARAM_STR);
    $statement->bindValue(":currency", $currency, PDO::PARAM_INT);
    $statement->execute();
}
else {

}
  header("Location: login.php");

?>
