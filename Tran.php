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

		<h2>Make a Transaction</h2>
		<br><br>
	
			
	
			<form action ="" method ="post">
				<input type="button" value = "Home" onclick = "location.href='trader.php'"><br><br>
				Choose ONE client by entering the client id:
				<select id="client_info" name="formid">
					<option value="" selected="selected"></option>
					<?php
						
						$servername = "127.0.0.1";
						$username = "root";
						$password = "";
						$dbname = "chitra";
						
						// Create connection
						$conn = mysqli_connect($servername, $username, $password, $dbname);
						// Check connection
						if (!$conn) {
							die("Connection failed: " . mysqli_connect_error());
						}
						
						//list all clients associated with the trader
						$sql = "SELECT s.user_id, p.first_name FROM user s, profile p WHERE s.user_id = p.user_id AND s.user_type = 1 AND s.user_id IN (SELECT client_id FROM associated_with WHERE trader_id = '$trader')" ;
						$result = mysqli_query($conn, $sql);
						// output data of each row
						//echo "<table border='2'>";
						if ((empty($_POST['submit1'])) AND (empty($_POST['submit2'])))
						{
							while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) 
							{
							$user_id = $row['user_id'];
							$first_name = $row['first_name'];
							$temp = $user_id;
							echo '<option value="' . $user_id . '">' 
						//      . $first_name 
								. $user_id
						        . '</option>';
							//echo "<tr>";
							//echo "<td>". "Client id: " . $user_id. "<td>". "Name: " . $first_name. "<br>";
						    //echo "<tr>";
							}
						}
						elseif((!empty($_POST['submit1'])) OR (!empty($_POST['submit2'])))
						{
							$_SESSION['client_id'] ="";
						//	$temp = $_POST['client_info'];
							$temp = $_POST['formid'];
							$_SESSION['client_id'] = $temp;
							
							if(!empty($_POST['submit1']))
							{
								header('Location: buy1.php');
							}
							elseif(!empty($_POST['submit2']))
							{
								header('Location: sell.php');
							}
						}
							
						mysqli_close($conn);
							
					?>	
				</select>
			</br>
				<input type="submit" name = "submit1" value = "Buy">
				<input type="submit" name = "submit2" value = "Sell">
				<br>
			</form>
		<body>
</html>