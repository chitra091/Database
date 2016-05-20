<?php
	session_start();
	$trader = $_SESSION['trader_id'];
?>

	<html>
		<head>
			<title> OTS
		</title>
		</head>
		<body>
			<h1>Oil Trading System</h1>
			<h3>Search Client</h3>
			<br>
			
			<form action="SrchClnt.php" method ="post">
				<input type="button" value = "Home" onclick = "location.href='trader.php'"><br><br>
				Enter Client name or address information:
				<input type="search" name="search">
				<input type="submit" name="submit" value="submit">
			</form>

		<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "chitra";
		if (isset($_POST['search']))
		{
			$string = ($_POST['search']);
			// Create connection
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			// Check connection
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
			$string_check = strval($string);
			if(is_string($string_check))
			{
				$sql = "SELECT p.user_id, p.first_name, p.last_name, p.street, p.city, p.state, p.zip_code, a.amount_due, a.oil_reserve, a.oil_shipped FROM user s, profile p, account_info a WHERE s.user_id = p.user_id AND s.user_id = a.user_id AND s.user_type = 1 AND (p.first_name LIKE '%". $string. "%' OR p.last_name LIKE '%". $string. "%' OR p.street LIKE '%". $string. "%' OR p.city LIKE '%". $string. "%' OR p.state LIKE '%". $string. "%')";
				$result = mysqli_query($conn, $sql);
					// output data of each row
					echo "<table border='2'>";
					while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) {
						$puser_id = $row['user_id'];
						$pfirst_name = $row['first_name'];
						$plast_name = $row['last_name'];
						$pstreet = $row['street'];
						$pcity = $row['city'];
						$pstate = $row['state'];
						$pzip_code = $row['zip_code'];
						$aamount_due = $row['amount_due'];
						$aoil_reserve = $row['oil_reserve'];
						$aoil_shipped = $row['oil_shipped'];
						
						echo "<tr>";
						echo "<td>". "Client id: " . $puser_id. "<td>". "Name: " . $pfirst_name. " " .$plast_name. "<td>" . "Address: - ". " ". $pstreet. " ". $pcity. " ". $pstate. " ". $pzip_code. "<td>". "Amount due: -" . " ". $aamount_due. " ". "<td>". "Oil reserve: -". " ". $aoil_reserve. " ". "<td>". "Oil Shipped: -". " ". $aoil_shipped. "<br>";
						echo "<tr>";
					}
			}
			else
			{
				echo "Error in search string";
			}
			mysqli_close($conn);
		}
		?>
	</body>
</html>