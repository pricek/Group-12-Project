<?php
   include('connectvars.php');
   session_start();

   $user_check = $_SESSION['logged_in_user'];

   $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

   $ses_sql = mysqli_query($conn,"select Username from Employees where Username = '$user_check' ");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['Username'];

   if(!isset($_SESSION['logged_in_user'])){
      header("location:login.php");
   }
?>
