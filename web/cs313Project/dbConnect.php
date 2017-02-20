<?php

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
?>
