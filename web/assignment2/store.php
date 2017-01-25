<?php
session_start();
if (!isset($_SESSION["user"])) {
	header("Location: login.php"); /* Redirect browser */
	exit();
}
$username = $_SESSION["user"];
?>
<!DOCTYPE html>

<html>
<head>
	<title>Welcome</title>
</head>

<body>
	<p>Welcome <?php echo $username; ?>!</p>

	<div>

		<form action="addRedCats.php" method="post">
			<input type="submit" value="Buy A Red Cat"></form>

		<form action="addBlueDogs.php" method="post">
			<input type="submit" value="Buy A Blue Dog"></form>

		<form action="addYellowOwls.php" method="post">
			<input type="submit" value="Buy A Yellow Owl"></form>

		<form action="addPurpleRats.php" method="post">
				<input type="submit" value="Buy A Purple Rat"></form>

		<br/>
		<br/>
		<p> <?php echo $username; ?> 's awful looking cart. no take backs once its bought its bought <p>
		<?php echo "You have bought " . $_SESSION["redCats"] . " red cats"; ?> <br/>
		<?php echo "You have bought " . $_SESSION["blueDogs"] . " blue dogs"; ?> <br/>
		<?php echo "You have bought " . $_SESSION["yellowOwls"] . " yellow owls"; ?> <br/>
		<?php echo "You have bought " . $_SESSION["purpleRats"] . " purple rats"; ?> <br/>
	</div>

<br/><br/>
<a href="logout.php">Logout</a>
</body>

</html>
