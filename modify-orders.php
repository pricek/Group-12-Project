<?php
include("pages.php");
$currentpage="Modify Orders";
session_start();

if(!isset($_SESSION['logged_in_user']))
 {
     echo '<script type="text/javascript">;
     alert("Please login before attempting access. Redirecting...");
     window.location = "http://web.engr.oregonstate.edu/~andrekyl/cs340/final/Group-12-Project/login.php";
     </script>';
 }
?>

<!DOCTYPE html>

<html>
	<head>
		<title>View Orders</title>
		<link rel="stylesheet" href="style.css">
	</head>
<body>

<body>

<?php

    function test_input($conn2, $data) {
       $data = mysqli_real_escape_string($conn2, $data);
       return $data;
    }

    include 'connectvars.php';
    include 'header.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
// Retrieve name of table selected
	
	$curOID = test_input($conn, $_GET[orderID]);

	$query = "SELECT C.Quantity, C.UnitCost, P.Description FROM OrderContents C, Products P WHERE C.OrderID = '$curOID' AND P.ProductID=C.ProductID";

	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}
// get number of columns in table
	$fields_num = mysqli_num_fields($result);
	echo "<h1>Order $_GET[orderID]:</h1>";
	echo "<table id='t01' border='1'><tr>";

// printing table headers
	for($i=0; $i<$fields_num; $i++) {
		$field = mysqli_fetch_field($result);
		echo "<td><b>$field->name</b></td>";
	}
	echo "</tr>\n";
	while($row = mysqli_fetch_row($result)) {
		echo "<tr>";
		// $row is array... foreach( .. ) puts every element
		// of $row to $cell variable
		foreach($row as $cell)
			echo "<td>$cell</td>";
		echo "</tr>\n";
	}
	echo "</table>";
	
	mysqli_free_result($result);

	if(false)
	{

	   $curOID = test_input($conn, $_GET[orderID]);

	   $query = "SELECT C.Quantity, C.UnitCost, P.Description FROM OrderContents C, Products P WHERE C.OrderID = '$curOID' AND P.ProductID=C.ProductID";

	   $result = mysqli_query($conn, $query);
	   if (!$result) {
	      die("Query to show fields from table failed");
	   }
	   
	   echo "<br>";
	   echo "<br>";
	   
	   $fields_num = mysqli_num_fields($result);
	   echo "<h2>Order $_GET[orderID] Contents:</h2>";
	   echo "<table id='t01' border='1'><tr>";
	   

	   for($i=0; $i<$fields_num; $i++) {
	      $field = mysqli_fetch_field($result);
	      echo "<td><b>$field->name</b></td>";
	   }
	   echo "</tr>\n";
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
