<?php
include("pages.php");
$currentpage="Buyers";
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
		<title>View Buyers</title>
		<link rel="stylesheet" href="style.css">
	</head>
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

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	   if(!empty($_POST["submit"]))
	   {
	      $curBID = test_input($conn, $_GET[bID]);
	      $address = test_input($conn, $_POST[address]);
	      $query = "INSERT INTO Orders (BuyerID, Date, ShipToAddress) VALUES('$curBID', '".date("Y-m-d")."', '$address')";
	      $result = mysqli_query($conn, $query);
	      if (!$result) {
		 echo $query;
		 die("Query failed");
	      }
	   }
	}
	
	mysqli_free_result($result);


	$query = "SELECT * FROM Buyers B";

	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}
// get number of columns in table
	$fields_num = mysqli_num_fields($result);
	echo "<h1>List of Buyers:</h1>";
	echo "<table id='t01' border='1'><tr>";

// printing table headers
	for($i=0; $i<$fields_num; $i++) {
		$field = mysqli_fetch_field($result);
		echo "<td><b>$field->name</b></td>";
	}
	echo "</tr>\n";
	while($row = mysqli_fetch_row($result)) {
		echo "<tr onclick=\"location.href='buyers.php?bID=$row[0]'\">";
		// $row is array... foreach( .. ) puts every element
		// of $row to $cell variable
		foreach($row as $cell)
			echo "<td>$cell</td>";
		echo "</tr>\n";
	}

  echo "</table>";

	mysqli_free_result($result);


  if($_GET[bID]!=-1)
  {
     $curDID = test_input($conn, $_GET[bID]);

     $query = "SELECT O.OrderID, O.Date, O.DollarAmount FROM Orders O, Buyers B WHERE B.BuyerID = '$curDID' AND O.BuyerID = B.BuyerID";

     $result = mysqli_query($conn, $query);
     if (!$result) {
        die("Query to show fields from table failed");
     }

     echo "<br>";
     echo "<br>";

     $fields_num = mysqli_num_fields($result);
     echo "<h2>Buyer $_GET[bID] Orders:</h2>";
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
     echo "<br><form method=\"post\" action=\"buyers.php?bID=$_GET[bID]\" class=\"inform\">";
     echo "<ul><li><label>Address:</label> <input name=\"address\" type=\"text\"></li>";
     echo "<li><input name=\"submit\" value=\"Add_Order\" type=\"submit\"></li>";
     echo "</form>";
  }

	mysqli_close($conn);
?>
</main>


</body>

</html>
