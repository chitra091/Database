<html>
	<head>
	</head>
	
	<body>
		<h1> View All Transactions </h1>
		
		<?php
			// Connect to the database
			$mysql_host = "localhost";
			$mysql_database = "chitra"; 
			$mysql_user = "root";
			$mysql_password = "";

			// Connection string
			$link = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database); 
				
			if (!$link) 
			{
				die("Connection failed: " . mysqli_connect_error());
			}
			
			$select = mysqli_query($link, "select * from all_transactions");
			
			echo "<table border='3'>";
			echo "<th> First Name </th>";
			echo "<th> Last Name </th>";
			echo "<th> Transaction ID </th>";
			echo "<th> Client ID </th>";
			echo "<th> Buy/Sell </th>";
			echo "<th> Transaction Fee </th>";
			echo "<th> Oil </th>";
			echo "<th> Commission Amount </th>";
			echo "<th> Commission: Cash/Oil </th>";
			echo "<th> Total Amount </th>";
			echo "<th> Total Oil </th>";
			echo "<th> Date of Request </th>";
			echo "<th> Date of Approval </th>";
			echo "<th> Shipped? </th>";
			
			while($array = mysqli_fetch_array($select,MYSQL_ASSOC)) 
			{
				$fname = $array['first_name'];
				$lname = $array['last_name'];
				$trans_id = $array['trans_id'];
				$client_id = $array['client_id'];
				$trans_type = $array['trans_type'];
				$trans_fee = $array['trans_fee'];
				$oil_requested = $array['oil_requested'];
				$comm_amt = $array['comm_amt'];
				$comm_type = $array['comm_type'];
				$total_amt = $array['total_amt'];
				$total_oil = $array['total_oil'];
				$dor = $array['dor'];
				$doa = $array['doa'];
				$shipped = $array['shipped'];
				
				echo "<tr>";
				echo "<td>" .$fname. "</td>";
				echo "<td>" .$lname. "</td>";
				echo "<td>" .$trans_id. "</td>";
				echo "<td>" .$client_id. "</td>";
				echo "<td>" .$trans_type. "</td>";
				echo "<td>" .$trans_fee. "</td>";
				echo "<td>" .$oil_requested. "</td>";
				echo "<td>" .$comm_amt. "</td>";
				echo "<td>" .$comm_type. "</td>";
				echo "<td>" .$total_amt. "</td>";
				echo "<td>" .$total_oil. "</td>";
				echo "<td>" .$dor. "</td>";
				echo "<td>" .$doa. "</td>";
				echo "<td>" .$shipped. "</td>";
				echo "</tr>";
				
			}
			echo "</table>";
			mysqli_close($link);
		?>
		<br>
		<button type="button" onclick="window.location='manager.php';"> Back </button>
	</body>
</html>