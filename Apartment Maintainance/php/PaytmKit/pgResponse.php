<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

include "../conn.php";

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

$resp = "";

session_start();
$user_in_session = $_SESSION['user'];

if($isValidChecksum == "TRUE") {
	//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		$sql = "SELECT flatid FROM flats WHERE phone='$user_in_session'";
		$query_id = mysqli_query($conn, $sql);

		$id = mysqli_fetch_assoc($query_id)['flatid'];
		$date = date('y/m/d');

		$payment_id = abs(hexdec(uniqid()));

		$sql_insert = "INSERT INTO maintenance(payment_by, paymentUniId, amount, payment_date) VALUES('$id', '$payment_id', 1800, '$date')";
		$query_insert = mysqli_query($conn, $sql_insert);

		if ($query_id && $query_insert) {
			$resp = "Success!";
		} else {
			echo mysqli_error($conn);
		}
	}
	else {
		$resp = "Failure";
	}

	/*if (isset($_POST) && count($_POST)>0 )
	{ 
		foreach($_POST as $paramName => $paramValue) {
				echo "<br/>" . $paramName . " = " . $paramValue;
		}
	}*/
}
else {
	echo "<b>Checksum mismatched.</b>";
	//Process transaction as suspicious.
}

?>

<html>
	<head>
		<title>Response</title>
	</head>

	<body style="display: flex; align-items:center; justify-content: center;">
		<div>
			<center>
				<?php 
					if ($resp == "Success!") {
						echo "<img src='C:/Users/U SAAI NATH/Desktop/Apartment Maintainance/assets/payment_success.jpg'>";
						echo "<h1>".$resp."</h1>";
						//echo "<br>Your payment id is ".$paymemt_id;

						echo "<br><a href='http://localhost:8000/templates/home.php'>Go back to home</a>";
					} else {
						echo "<h1>".$resp."</h1>";
					}
				?>
			</center>
		</div>
	</body>
</html>