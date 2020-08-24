<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php 
	// CHECKING IF A USER IS LOGGED IN 
	if (!isset($_SESSION['user_id']))  {
		header('Location: index.php');
	
}
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Users</title>
	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
	<header>
		<div class="appname">User Management System</div>	
		<div class="loggedin">Welcome <?php  echo $_SESSION['first_name']; ?>! <a href="logout.php">Log Out</a></div>

	</header>
	<h1>Users</h1>
</body>
</html>