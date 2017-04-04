
<?php
	session_start();
	/*
	if (!isset($_SESSION["username"])) {
		header("Location: loginError.php"); //Redirect browser
		exit();
	}
	*/

	require_once('dbconnect.php');

  //uncomment later
	//$username = $_SESSION["username"];

  //temporary for testing
	$username = "Megan123";


	// GRAB VALUES FOR THESE VARIABLES
	$id;   //
	$name; //
	$accounts = array();

	/**************************************************
	*  Queries
	**************************************************/
	// get the name and account holder id
	$statement = $db->prepare("SELECT name, id
														 FROM account_holder
														 WHERE username = :username;");
	$statement->bindValue(":username", $username, PDO::PARAM_STR);
	$statement->execute();

	$name = $row['name'];
	$id   = $row['id'];

	// get the accounts, their number and amounts
	$statement = $db->prepare("SELECT b.id, b.account_num, b.account_amount
														 FROM account_holder_to_bank_account t
														 INNER JOIN bank_account b on t.bank_account_id = b.id
														 WHERE t.account_holder_id = :id;");
	$statement->bindValue(":id", $id, PDO::PARAM_INT);
	$statement->execute();

	$totalAccounts = 0;
	// Go through each result
	while($row = $statement->fetch(PDO::FETCH_ASSOC))
	{
		$accounts["id" + $totalAccounts]             = $row['id'];
		$accounts["account_num" + $totalAccounts]    = $row['account_num'];
		$accounts["account_amount" + $totalAccounts] = $row['account_amount'];

		$totalAccounts++;
	}

	$currAccount = 0;

	// THIS IS GONNA BREAK THE SECOND SOMEONE HAS MORE THAN ONE ACCOUNT
	while ($currAccount < $totalAccounts)
	{
		// get the transaction events, their date and amounts
		$statement = $db->prepare("SELECT e.transaction_amount, e.transaction_date
															 FROM transaction_history t
															 INNER JOIN transaction_event e on t.transaction_history = e.id
															 WHERE t.bank_account_id = :id;");
		$statement->bindValue(":id", $accounts["id" + $currAccount], PDO::PARAM_INT);
		$statement->execute();

		$totalTransactions = 0;
		// Go through each result
		while($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			$transactionEvents = array();
			$transactionEvents["transaction_amount" + $totalTransactions] = $row['transaction_amount'];
			$transactionEvents["transaction_date" + $totalTransactions]   = $row['transaction_date'];

			$accounts["transactionHistory" + $currAccount] = $transactionEvents;

			$totalTransactions++;
		}
	}


?>
