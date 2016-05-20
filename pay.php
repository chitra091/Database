<?php
	session_start();
	$username = $_SESSION['username'];
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
		
			// Connect to the database
			$mysql_host = "localhost";
			$mysql_database = "chitra"; 
			$mysql_user = "root";
			$mysql_password = "";

			// Connection string
			$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database); 
			
			// Fetching the user_id
			$result_user = mysqli_query($link,"select * from user where login_name='$username'");
			$array_user = mysqli_fetch_array($result_user,MYSQL_ASSOC); 
			$user_id = $array_user['user_id'];
			
			// Fetching the unpaid transactions
			$select_pid = mysqli_query($link,"SELECT * FROM payment_details a, payment_transaction b where a.payment_id=b.payment_id AND client_id='$user_id' AND dop IS NULL");
			 
						
			echo "<table border='2'>";
			$count=0;
			
			for($i=0; $i<=$count; $i++) 
			{ 
				while($array_pid = mysqli_fetch_array($select_pid,MYSQL_ASSOC))
				{
					$count++;
					
					$trans_id = $array_pid['trans_id'];
					
					
					echo "<tr><td>";
					echo "Transaction ID: " .$trans_id;
					echo "<a href='payment_details.php?trans_id=".$trans_id."'> Click </a>";
					echo "</td></tr>";
					echo "<br>";
				}
			}
			echo "</table>";
			mysqli_close($link);
		?>
		
		<h2><button type="button" onclick="window.location='client.php';"> Back </button></h2>
		
	</body>
</html>