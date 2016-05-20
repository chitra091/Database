<html>
	<head>
	</head>
	
	<body>
		<h1>View monthly transactions </h1>
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
			
			$select = mysqli_query($link, "select * from monthly_transactions");
			
			echo "<table border='3'>";
			echo "<th> Month </th>";
			echo "<th> No. of transactions </th>";
						
			while($array = mysqli_fetch_array($select,MYSQL_ASSOC)) 
			{
				$month = $array['monthname'];
				$total = $array['totaltransactions'];
								
				echo "<tr>";
				echo "<td>" .$month. "</td>";
				echo "<td>" .$total. "</td>";
				echo "</tr>";
				
			}
			echo "</table>";
			mysqli_close($link);
		?>
		<br>
		<button type="button" onclick="window.location='manager.php';"> Back </button>
	</body>
</html>