<?php
include("pages.php");
$currentpage="Distributors";
session_start();

if(!isset($_SESSION['logged_in_user']))
 {
  header("location: login.php");
 }
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Distributors</title>
		<link rel="stylesheet" href="style.css">
	</head>
<body>

<?php

    include 'connectvars.php';
    include 'header.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
// Retrieve name of table selected

	$query = "SELECT D.DistributorID, D.ZipCode , D.Name FROM Distributors D";

	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}
// get number of columns in table
	$fields_num = mysqli_num_fields($result);
	echo "<h1>List Distributors:</h1>";
	echo "<table id='t01' border='1'><tr>";

// printing table headers
	for($i=0; $i<$fields_num; $i++) {
		$field = mysqli_fetch_field($result);
		echo "<td><b>$field->name</b></td>";
	}
	echo "</tr>\n";
	while($row = mysqli_fetch_row($result)) {
		echo "<tr onclick=\"location.href='distributors.php?dID=$row[0]'\">";
		// $row is array... foreach( .. ) puts every element
		// of $row to $cell variable
		foreach($row as $cell)
			echo "<td>$cell</td>";
		echo "</tr>\n";
	}
	echo "</table>";
	mysqli_free_result($result);

	if($_GET[dID]!=-1)
	{
	   $query = "SELECT P.Description FROM DistributorStock S, Products P WHERE S.DistributerID = '$_GET[dID]' AND P.ProductID = S.ProductID";

	   $result = mysqli_query($conn, $query);
	   if (!$result) {
	      die("Query to show fields from table failed");
	   }
	   
	   echo "<br>";
	   echo "<br>";
	   
	   echo "<h2>Distributor $_GET[dID] Stock:</h2>";
	   echo "<table id='t01' border='1'><tr>";
	   

	   while($row = mysqli_fetch_row($result)) {
	      echo "<tr>";
	      // $row is array... foreach( .. ) puts every element
	      // of $row to $cell variable
	      foreach($row as $cell)
		 echo "<td>$cell</td>";
	      echo "</tr>\n";
	   }
	   echo "</table>";

	}

	mysqli_free_result($result);
	mysqli_close($conn);
?>
</main>


</body>

</html>
