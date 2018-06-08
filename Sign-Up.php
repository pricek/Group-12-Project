<!DOCTYPE html>
<?php
include("pages.php");
$currentpage="Login";
?>

<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="style.css">
	</head>
<body>

<body>

<?php

    include 'connectvars.php';
    include 'header.php';
	$page = "signup";
	$usernameError = $firstNameError = $lastNameError = $emailError = $passwordError = $ageError = "";
	$username = $firstName = $lastName = $email = $password = $age = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysql_error());
        }

		$page = "success";
	  	if (empty($_POST["username"])) {
	    	$usernameError = "Username is required";
	    	$page = "errors";
	  	} else {
	    	$username = test_input($conn, $_POST["username"]);
	  	}

        $queryIn = "SELECT * FROM Users where username='$username' ";
        $resultIn = mysqli_query($conn, $queryIn);
		if (mysqli_num_rows($resultIn)> 0) {
			$usernameError = "That username is already taken";
            $page = "errors";
		}

	  	if (empty($_POST["firstName"])) {
	  		$firstNameError = "First name is required";
	  		$page = "errors";
	  	} else {
	  		$firstName = test_input($conn, $_POST["firstName"]);
	  	}
	  	if (empty($_POST["lastName"])) {
	  		$lastNameError = "Last name is required";
	  		$page = "errors";
	  	} else {
	  		$lastName = test_input($conn, $_POST["lastName"]);
	  	}
	  	if (empty($_POST["password"])) {
	  		$passwordError = "Password is required";
	  		$page = "errors";
	  	} else {
	  		$password = test_input($conn, $_POST["password"]);
	  	}
        if (empty($_POST["eID"])) {
	    	$eIDError = "EID is required";
	    	$page = "errors";
	  	} else {
	    	$eID = test_input($conn, $_POST["eID"]);
	  	}
	}

    if ($page == "success")
	{
        $salt = generateRandomSalt();

        $query = "INSERT INTO Employees (Username, FirstName, LastName, Password, EmployeeID, Salt) VALUES ('$username', '$firstName', '$lastName', MD5('$password$salt'), '$eID', '$salt')";
        if(!mysqli_query($conn, $query)){
			echo "ERROR: Could not execute $query. " . mysqli_error($conn);
            $page = "errors";
		}
	}

	function test_input($conn2, $data) {
        $data = mysqli_real_escape_string($conn2, $data);
  		return $data;
	}

    function generateRandomSalt(){
        return base64_encode(mcrypt_create_iv(12, MCRYPT_DEV_URANDOM));
    }
    mysqli_close($conn);
?>

<main>

	<?php
		if ($page != "success")
		{
			?>

				<h1>Sign Up</h1>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="inform">
				<ul>
				<li><label>Username:</label> <input type="text" name="username" value=<?php $username; ?>>
				<span class="error"> * <?php echo $usernameError;?></span>
				<li><label>First Name:</label> <input type="text" name="firstName" value=<?php $firstName; ?>>
				<span class="error"> * <?php echo $firstNameError;?></span>
				<li><label>Last Name:</label> <input type="text" name="lastName" value=<?php $lastName; ?>>
				<span class="error"> * <?php echo $lastNameError;?></span>
				<li><label>Password:</label> <input type="password" name="password" value=<?php $password; ?>>
				<span class="error"> * <?php echo $passwordError;?></span>
                <li><label>EID:</label> <input type="text" name="eID" value=<?php $eID; ?>>
				<span class="error"> * <?php echo $eIDError;?></span>
				<li><input type="submit">
				</form>

				<br>
				<label class="error">*Required Field</label>
			<?php
		} else if ($page == "success")
		{
            echo '<h2>Sign up successful</h2> <p>Click <a href="Sign-Up.php">here</a> to return to sign up</p>';
		}
	?>
</main>

</body>

</html>
