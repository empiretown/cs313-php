<!-- THIS PAGE IS PURELY FOR TESTING PURPOSES -->

<!DOCTYPE html>
<html>
<head>
	<title>TESTING</title>
</head>

<body>

	<div style="text-align: center;">
		<br/><br/>

    <?php
////////////////// TEST CODE HERE ////////////////////////
session_start();

$itemId = $_POST["itemId"];
$sellPrice = $_POST["sellPrice"];

echo "Item id: " . $itemId . "   Sellprice: " . $sellPrice . "<br/>";



///////////////////// UP TO HERE ////////////////////////
    ?>

	</div>
</body>
</html>
