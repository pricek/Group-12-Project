<!DOCTYPE html>
<?php
include("pages.php");
$currentpage="Log In";
?>

<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="style.css">
	</head>
<body>

<?php

    include 'connectvars.php';
    include 'header.php';
    $error = "";

    $page = "signin";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $error = "Username or Password is incorrect";

        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if (!$conn) {
            die('Could not connect: ' . mysql_error());
        }
        $username = test_input($conn, $_POST["username"]);
	  	$password = test_input($conn, $_POST["password"]);
	}
        $queryIn = "SELECT Salt FROM Employees WHERE username='$username' ";
        $resultIn = mysqli_query($conn, $queryIn);

        if($row = mysqli_fetch_assoc($resultIn)) {
            $salt = $row['Salt'];
            $querySalt = "SELECT Username FROM Employees WHERE Username='$username' AND Password=MD5('$password$salt')";
            $resultSalt = mysqli_query($conn, $querySalt);
            if(mysqli_num_rows($resultSalt)>0) {
                $page = "success";
            }
        }

	function test_input($conn2, $data) {
        $data = mysqli_real_escape_string($conn2, $data);
  		return $data;
	}
    mysqli_close($conn);
?>

<main>

	<?php
		if ($page != "success")
		{
			?>

				<h1>Log In</h1>

                <span class="error"><?php echo $error;?></span>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="inform">
				<ul>
				<li><label>Username:</label> <input type="text" name="username" value="">
				<li><label>Password:</label> <input type="password" name="password" value=>
				<li><input type="submit">
				</form>
			<?php
		} else if ($page == "success")
		{
            echo '<h2>Log in successful</h2>';
		}
	?>
</main>

</body>

</html>
