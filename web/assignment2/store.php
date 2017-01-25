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

	<div style="text-align: center;">
		<br/><br/>
		<p>Welcome <?php echo $username; ?>!</p>
		<p> Store items: </p>
		<form action="addRedCats.php" method="post">
			<input type="submit" value="Buy A Red Cat"></form><br/>

		<form action="addBlueDogs.php" method="post">
			<input type="submit" value="Buy A Blue Dog"></form><br/>

		<form action="addYellowOwls.php" method="post">
			<input type="submit" value="Buy A Yellow Owl"></form><br/>

		<form action="addPurpleRats.php" method="post">
				<input type="submit" value="Buy A Purple Rat"></form><br/>

		<br/>
		<br/>
		<p> <?php echo $username; ?> 's awful looking cart: <p>
		<?php echo "You have bought " . $_SESSION["redCats"] . " red cats"; ?>
		<form action="removeRedCats.php" method="post">
			<input type="submit" value="Remove Red Cat"></form><br/>

		<?php echo "You have bought " . $_SESSION["blueDogs"] . " blue dogs"; ?>
		<form action="removeBlueDogs.php" method="post">
			<input type="submit" value="Remove Blue Dog"></form><br/>

		<?php echo "You have bought " . $_SESSION["yellowOwls"] . " yellow owls"; ?>
		<form action="removeYellowOwls.php" method="post">
			<input type="submit" value="Remove Yellow Owl"></form><br/>

		<?php echo "You have bought " . $_SESSION["purpleRats"] . " purple rats"; ?>
		<form action="removePurpleRats.php" method="post">
			<input type="submit" value="Remove Purple Rat"></form><br/>

			<br/><br/>
			<a href="logout.php">Logout</a>
	</div>
</body>

</html>
