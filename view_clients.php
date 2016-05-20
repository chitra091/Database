 <html>
	<head>
	</head>
	
	<body>
		<h1> View All Clients </h1>
		
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
			
			$select = mysqli_query($link, "select * from all_clients");
			
			echo "<table border='3'>";
			echo "<th> User ID </th>";
			echo "<th> Login Name </th>";
			
			while($array = mysqli_fetch_array($select,MYSQL_ASSOC)) 
			{
				$user_id = $array['user_id'];
				$login_name = $array['login_name'];
				
				echo "<tr><td>";
				echo $user_id. " </td><td>" .$login_name;
				echo "</td></tr>";
				
			}
			echo "</table>";
			mysqli_close($link);
		?>
		<br>
		<button type="button" onclick="window.location='manager.php';"> Back </button>
	</body>
</html>