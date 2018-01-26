<?php
	session_start();
	
	$Email = $_SESSION['email'];
?>
<html lang="en-US">

<!-- Group 3 -->
<title>Paradise of the Seas</title>

<!--  CSS Code -->
<style type = "text/css">
body
{
	margin:auto;
	background-size: 100% 100%;
	background-repeat: no-repeat;
	background-attatchment: scroll;
}
div.log
{
	margin-left: auto;
	overflow: auto;
	color: black;
	background-color: rgba(255, 255, 255, 0.7);
	width: 175px;
	padding: 5px;
	border-radius: 5px;
	text-align: center;
}
div.nav
{
	margin-top: 150px;
	background-color: rgba(255, 255, 255, 0.7);
	margin: auto;
	overflow: auto;
	font-size: 20px;
	text-transform: uppercase;
	display: block;
	color: black;
	font-weight: bold;
	padding: 20px;
}

ul.nav
{
	padding: 0;
	margin: 0 auto;
	list-style: none;
	text-align: center;
	width: 450px;
}

li.nav
{
	width: 150px;
	float: left;
	text-align: center;
	color: black;
}

a:link
{
	text-decoration: none;
}

a:visited
{
	color: black;
}
select
{
	background-color: rgba(255, 255, 255, 0.7);
	width: 150px;
	padding: 5px;
	font-size: 16px;
	line-height: 1;
	border: 0;
	border-radius: 5px;	
	height: 40px;
}
input[type = submit].searchCruises
{
	background-color: rgba(255, 255, 255, 0.7);
	border: none;
	padding: 7px;
	border-radius: 5px;
}
div.tableBorder
{
	background-color: rgba(255, 255, 255, 0.7);
	width: 1500px;
	margin: auto;
	padding: 20px;
	border-radius: 5px;
}
table
{
	width: 1500px;
	border-collapse: collapse;
}
tr.header
{
	font-size: 20px;
	padding: 50px;
}
td.header
{
	padding: 5px;
	border: solid black 1px;
}
tr.results
{
	font-size: 18px;
}
td.results
{
	padding: 3px;
}
tr.results:hover
{
	background-color: rgba(128, 191, 255, 0.7);
}
input[type = submit].book
{
	background-color: rgba(255, 255, 255, 0);
	border: 1px solid black;
	border-radius: 5px;
}

</style>


<body background = "beach.png">

<?php
	if(empty($Email) == "true")
	{ 
		echo '<div align = "right" class = "log">';
			echo '<a href="logIn.php">Log In / </a>';
			echo '<a href="signUp.php">Create Account</a>';
		echo '</div>';
	}
	else
	{ 
		echo '<div align = "right" class = "log">';
			echo '<a href="userPage.php">View Info / </a>';
			echo '<a href="logout.php">Logout</a>';
		echo '</div>';
	} 
?>

<h1 align = "center"><b><strong><font size = "7">Paradise of the Seas</font></strong></b></h1>

<div class = "nav">
	<ul class = "nav">
		<li class = "nav"><a href = "homepage.php"> Home</a></li>
		<li class = "nav"><a href = ""> Deals</a></li>
		<li class = "nav"><a href = ""> Support </a></li>
	</ul>
</div>

<br>

<form action = "" method = "POST" align = "center">

	<!-- Select Departing Date -->
	<select name = "departingDate" id = "departingDate" align = "center">
		<option selected hidden style = 'display: none' value = "0">Departure Date</option>
		<?PHP			
			$hostname = "students";
			$username = "cs566103";
			$password = "GGgH9dH9H";
			$db = "cs566103";

			// Connect to MySQL Database
			$conn = mysqli_connect($hostname, $username, $password, $db);
			if (!$conn) 
			{
				die("Could not connect: " . mysqli_connect_error());
			}
		
			// MySQL statement
			$sql = "SELECT DateLaunched from Itinerary ORDER BY DateLaunched";
		
			// Execute MySQL statement
			$result = mysqli_query($conn, $sql);
			if (!$result) 
			{
				die("Could not execute sql:" . mysqli_error($conn));
			}

			// Display Results
			while ($row = mysqli_fetch_array($result)) 
			{
				echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
			}
		?>
	</select>
	
	<!-- Select Departing From -->
	<select name = "departingFrom" id = "departingFrom"> 
		<option selected hidden style = 'display: none' value = "0" align = "center">Departing From</option>
		<?PHP
			// SQL statement
			$sql = "SELECT DepartingFrom FROM Itinerary ORDER BY DepartingFrom";
	
			// Execute SQL statement
			$result = mysqli_query($conn, $sql);
			if (!$result) 
			{
				die("Could not execute sql:" . mysqli_error($conn));
			}
		
			// Display Results
			while ($row = mysqli_fetch_array($result)) 
			{
				echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
			}
		?>
	</select>

	<!-- Select Destination -->
	<select name = "destination" id = "destination">
		<option selected hidden style = 'display: none' value = "0">Destination</option>
		<?PHP
			// MySQL statement
			$sql = "SELECT Destination from Itinerary ORDER BY Destination";
	
			// Execute MySQL statement
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				die("Could not execute sql:" . mysqli_error($conn));
			}

			// Display Results
			while ($row = mysqli_fetch_array($result)) 
			{
				echo "<option value='" . $row[0] . "'>" . $row[0] . "</option>";
			}			
		?>
	</select>

	<input type="submit" class = "searchCruises" name = "doSearch" value = "Search Cruises">
</form>

<br>

<?php
if ($_POST['doSearch'] == "Search Cruises")
{
	if (empty($Email) == "true")
	{
		$onBook = "logIn.php";
	}
	else
	{
		$onBook = "book.php";
	}
			
	$launchDate = $_POST['departingDate'];
	$departingFrom = $_POST['departingFrom'];
	$destination = $_POST['destination'];
	
	// MySQL statement
	// If all fields are empty
	if ($launchDate == "0" && $departingFrom == "0" && $destination == "0") 
	{
		$sql = "SELECT *
				FROM Itinerary
				ORDER BY DateLaunched;";
	}
	// If Departure Date is selected
	elseif ($departingFrom == "0" && $destination == "0")
	{
		$sql = "SELECT ShipName, DateLaunched, DepartingFrom, Destination 
				FROM Itinerary I 
				WHERE DateLaunched = '$launchDate'
				ORDER BY DateLaunched;";
	}
	// If Departing From is selected
	elseif ($launchDate == "0" && $destination == "0")
	{
		$sql = "SELECT ShipName, DateLaunched, DepartingFrom, Destination 
				FROM Itinerary I 
				WHERE DepartingFrom = '$departingFrom'
				ORDER BY DateLaunched;"; 
	}
	// If Destination is selected
	else
	{
		$sql = "SELECT ShipName, DateLaunched, DepartingFrom, Destination 
				FROM Itinerary I 
				WHERE Destination = '$destination'
				ORDER BY DateLaunched;";
	}
	
	
	// Execute MySQL statement
	$result = mysqli_query($conn, $sql);
	if (!$result) 
	{
		die("Could not execute sql:" . mysqli_error($conn));
	}

	// Retrieve the number of rows in the result set
	$num_rows = mysqli_num_rows($result);
	if ($num_rows == 0)
	{
		die("Failed to find cruises." . mysqli_error($conn));
	}
	echo '<div align = "center" class = "tableBorder">';
	// Display Table of cruises
	echo '<table>';
		echo '<tr class = "header">';
			echo '<td class = "header">Ship</td>';
			echo '<td class = "header">Departure Date</td>';
			echo '<td class = "header">Departing From</td>';
			echo '<td class = "header">Destination</td>';
			//echo '<td>Price</td>';
		echo '</tr>';
	
		while ($row = mysqli_fetch_array($result)) 
		{
		echo '<form method="post" action= ', $onBook, '>';
		echo '<tr class = "results">';
			echo '<td class = "results" name = "ShipName">', 		($row["ShipName"]),		'</td>';
			echo '<td class = "results" name = "DateLaunched">', 		($row["DateLaunched"]), '</td>';
			echo '<td class = "results" name = "DepartingFrom">', 		($row["DepartingFrom"]), '</td>';
			echo '<td class = "results" name = "Destination">', trim  (($row["Destination"])), 	'</td>';
		
			echo '<input type="hidden" name="ShipName" 		id="ShipName" 		value="', $row["ShipName"],		'">';
			echo '<input type="hidden" name="DateLaunched" 	id="DateLaunched" 	value="', $row["DateLaunched"], '">';
			echo '<input type="hidden" name="Location" 		id="Location" 		value="', $row["Location"],		'">';
			echo '<th class = "book"><input type="submit" class = "book" name="submit" value="Book"></th>';
		echo '</tr>';
		echo '</form>';
		}
	echo '</table>';
	echo '</div>';
}
	// Free result set
	mysqli_free_result($result);

	// Close the MySQL connection
	mysqli_close($conn);

?>

</body>
</html>
	