<?php
include("pages.php");
$currentpage="Home";
session_start();

    include 'connectvars.php';
    include 'header.php';
    $error = "";
?>
<!DOCTYPE html>

	<html>
		<head>
			<title>Home</title>
			<link rel="stylesheet" href="style.css">
		</head>
	<body>
<div class="homepage">
  <h2> Welcome to the Group 12 Wholesale Warehouse Database</h2>

  <img src="warehouse.jpg" alt="Warehouse" class="office">
    
    <p> A picture of our lovely building, located in Scranton, PA </p>    
    
    <p> *Employees please proceed to the Log In page, if you need to create an account please speak with an Admin.</p>
</div>
</body>

</html>
