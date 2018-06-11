<?php
include("pages.php");
$currentpage="View Orders";
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
    
    function deleteContents($pID, $oID) {
       $query = "DELETE FROM OrderContents WHERE OrderID=$oID AND ProductID=$pID";
       $result = mysqli_query($conn, $query);
       if (!$result) {
	  echo $query;
	  die("Query failed");
       }
    }

    include 'connectvars.php';
    include 'header.php';

	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (!$conn) {
		die('Could not connect: ' . mysql_error());
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	   if(!empty($_POST[delete]))
	   {
	      $curOID = test_input($conn, $_GET[orderID]);
	      $pID = test_input($conn, $_POST[PID]);
	      echo $pid;
              $query = "DELETE FROM OrderContents WHERE OrderID=$curOID AND ProductID=$pID";
       	      $result = mysqli_query($conn, $query);
       	      if (!$result) {
       		 echo $query;
       		 die("Query failed");
       	      }
	   }
	   else
	   {
	      $curOID = test_input($conn, $_GET[orderID]);
	      $pID = test_input($conn, $_POST[ProductID]);
	      $quantity = test_input($conn, $_POST[Quantity]);
	      $query = "SELECT Cost FROM Products WHERE ProductID = $pID";
	      $result = mysqli_query($conn, $query);
	      $row = mysqli_fetch_row($result);
	      
	      $query = "INSERT INTO OrderContents VALUES('$curOID', '$pID', '$quantity', '$row[0]')";
	      $result = mysqli_query($conn, $query);
	      if (!$result) {
		 echo $query;
		 die("Query failed");
	      }
	   }
	}

// Retrieve name of table selected

	$query = "SELECT O.OrderID, O.Date , O.DollarAmount, O.ShipToAddress, O.BuyerID FROM Orders O";

	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query to show fields from table failed");
	}
// get number of columns in table
	$fields_num = mysqli_num_fields($result);
	echo "<h1>List of Orders:</h1>";
	echo "<table id='t01' border='1'><tr>";

// printing table headers
	for($i=0; $i<$fields_num; $i++) {
		$field = mysqli_fetch_field($result);
		echo "<td><b>$field->name</b></td>";
	}
	echo "</tr>\n";
	while($row = mysqli_fetch_row($result)) {
		echo "<tr onclick=\"location.href='view-orders.php?orderID=$row[0]'\">";
		// $row is array... foreach( .. ) puts every element
		// of $row to $cell variable
		foreach($row as $cell)
			echo "<td>$cell</td>";
		echo "</tr>\n";
	}
	echo "</table>";
	
	mysqli_free_result($result);

	if($_GET[orderID]!=-1)
	{

	   $curOID = test_input($conn, $_GET[orderID]);

	   $query = "SELECT P.ProductID, C.Quantity, C.UnitCost, P.Description FROM OrderContents C, Products P WHERE C.OrderID = '$curOID' AND P.ProductID=C.ProductID";

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
	      echo "<tr onclick=\"deleteContentsJS($row[0], $curOID)\">";
	      // $row is array... foreach( .. ) puts every element
	      // of $row to $cell variable
	      foreach($row as $cell)
		 echo "<td>$cell</td>";
              echo "<td><form method=\"post\" action=\"view-orders.php?orderID=$_GET[orderID]\" class=\"inform\">";
	      echo "<input type=\"hidden\" name=\"PID\" value=\"$row[0]\">";
	      echo "<input type=\"submit\" name=\"delete\" value=\"delete\"></form></td>";
	      echo "</tr>\n";
	   }
	   echo "</table>";
	   echo "<br>";
	   $query = "SELECT ProductID FROM Products";
	   $result = mysqli_query($conn, $query);
	   
	   echo "<br><form method=\"post\" action=\"view-orders.php?orderID=$_GET[orderID]\" class=\"inform\">";
	   echo "<ul><li><label>Product ID </label><select name=\"ProductID\">";
	   while($row = mysqli_fetch_row($result)) {
	      echo "<option value=\"$row[0]\">$row[0]</option>";
	   }
	   echo "</select></li>";
	   echo "<li><label>Quantity </label><input name=\"Quantity\" type=\"number\" min=1 max=10></li>";
	   echo "<li><input type=\"submit\" value=\"Add Contents\"></li>";
	   echo "</form>";
	}

	mysqli_free_result($result);
	mysqli_close($conn);
?>

</main>


</body>

</html>
