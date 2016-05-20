<?php
	session_start();
	$username = $_SESSION['username'];
	$trans_id = $_GET['trans_id'];
?>

<html>
	<head>
		<title> OTS
		</title>
	</head>
	
	<body>
		<h1> Client - Payment </h1>
		<a href="logout.php" align="right"> Logout </a>
		<h2> Hello, <?php echo $username;?></h2>
		
		<?php 
		echo "Transaction ID: " .$trans_id;
		echo "<br>";
		// Connect to the database
		$mysql_host = "localhost";
		$mysql_database = "chitra"; 
		$mysql_user = "root";
		$mysql_password = "";

		// Connection string
		$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database); 
		
		$select_amt = mysqli_query($link,"select * from transaction where trans_id='$trans_id'");
		$array_amt = mysqli_fetch_array($select_amt,MYSQL_ASSOC); 
		$amt_due = $array_amt['total_amt'];
		echo "Amount to be paid: " .$amt_due;
		echo "<br><br>";
		?> 
		
		<form method="post">
			<input type="submit" name="pay" value="Confirm Payment">
		</form>
		
		<?php
			$dop = date('y/m/d');
			
			if(isset($_POST['pay'])) 
			{
				$update_pay = mysqli_query($link,"update payment_details set dop='$dop' where trans_id='$trans_id'");
				$select_pid = mysqli_query($link,"select * from payment_details where trans_id='$trans_id'");
				$array_pid = mysqli_fetch_array($select_pid,MYSQL_ASSOC); 
				$pid = $array_pid['payment_id'];
				echo $pid;
				
				$update_amt = mysqli_query($link,"update payment_transaction set amt_paid='$amt_due' where payment_id='$pid'");
				
				echo "Payment Successful !!!";
				
				$select = mysqli_query($link, "select * from user where login_name='$username'");
				$array = mysqli_fetch_array($select,MYSQL_ASSOC);
				$user_id = $array['user_id'];
				
				$result_account = mysqli_query($link,"select * from account_info where user_id='$user_id'");
				$array_account = mysqli_fetch_array($result_account,MYSQL_ASSOC); 
				$amount_due = $array_account['amount_due'];
				
				$amount_due = $amount_due - $amt_due;
				
				$update_account = mysqli_query($link, "update account_info set amount_due='$amount_due' where user_id='$user_id'");
			}
		
			mysqli_close($link);
		?>
		
		<h2><button type="button" onclick="window.location='client.php';"> Continue </button></h2>
	</body>
</html>