<!DOCTYPE html>
<html>
<head>
	<title>Log in</title>
</head>

<body>
	<div style="text-align: center;">
		<br/><br/>
		<p>Please log in:</p>

		<form action="authenticate.php" method="post">
			<input type="text" name="username" placeholder="username"><br/><br/>
      <input type="password" name="password" placeholder="password"><br/><br/>
			<input type="submit" value="Login">
		</form>

		<br/><br/>

		<p>Or create an account</p> <br/>
		<form action="createUser.php" method="post">
			<input type="text" name="firstName" placeholder="First Name"><br/><br/>
			<input type="text" name="lastName" placeholder="Last Name"><br/><br/>
			<input type="text" name="usernameC" placeholder="Username"><br/><br/>
      <input type="password" name="passwordC" placeholder="Password"><br/><br/>
			<input type="password" name="passwordC2" placeholder="Reenter Password"><br/><br/>
			<input type="submit" value="Create User">
		</form>

	</div>
</body>
</html>
