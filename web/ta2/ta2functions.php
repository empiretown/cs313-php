
<?php session_start();

echo "im in here";
exit;


if (filter_input(INPUT_POST, 'action))'{
    $action = filter_input(INPUT_POST, 'action');
} else {
    $action = filter_input(INPUT_GET, 'action');
}

$name = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$major = filter_input(INPUT_POST, 'major');
$comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING);

$error = "";

if(empty($name) || empty($email) || empty($major) || empty($comments)) {
  $error = "YOU MESSED UP";
}

include 'ta2Results.php';

exit;
?>
