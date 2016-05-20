<html>
	<head>
	</head>
	
	<body>
		<h1>View gold level customers </h1>
		
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
			
			$select = mysqli_query($link, "select * from gold_level_clients");
			
			echo "<table border='3'>";
			echo "<th> First Name </th>";
			echo "<th> Last Name </th>";
			echo "<th> Client ID </th>";
			echo "<th> Trader ID </th>";
			
			while($array = mysqli_fetch_array($select,MYSQL_ASSOC)) 
			{
				$fname = $array['first_name'];
				$lname = $array['last_name'];
				$client_id = $array['client_id'];
				$trader_id = $array['trader_id'];
				
				echo "<tr>";
				echo "<td>" .$fname. "</td>";
				echo "<td>" .$lname. "</td>";
				echo "<td>" .$client_id. "</td>";
				echo "<td>" .$trader_id. "</td>";
				echo "</tr>";
				
			}
			echo "</table>";
			mysqli_close($link);
		?>
		<br>
		<button type="button" onclick="window.location='manager.php';"> Back </button>
	</body>
</html>