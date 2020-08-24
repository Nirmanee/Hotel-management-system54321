<?php session_start() ?>
<?php require_once ('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

	 $errors = array();
	 $first_name = '';
	 $last_name = '';
	 $email = '';
	 $password = '';
	
	if (isset($_POST['submit'])) {
		 $first_name = $_POST['first_name'];
	     $last_name = $_POST['last_name'];
	 	 $email = $_POST['email'];
		 $password = $_POST['password'];

		//checking required fields		
		$req_fields = array('first_name', 'last_name', 'email', 'password');

		foreach ($req_fields as $field) {
		if (empty(trim($_POST[$field]))) {
			$errors[] ='- ' .  $field . ' is required';
		
			}	
		}
		//checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email'=>100, 'password' =>40);

		foreach ($max_len_fields as $field => $max_len) {
		if (strlen(trim($_POST[$field])) > $max_len) {
			$errors[] = '- ' . $field . ' must be less than ' . $max_len . ' characters';
		
			}	
		}
			//checking email address
		if (!is_email($_POST['email'])){
			$errors[]= '- Email Address is invalid.';
		}
			 

	     	// checking email address already exists
		  $email = mysqli_real_escape_string($connection, $_POST['email']);
		  $query = "SELECT * FROM user WHERE email = '{$email}'LIMIT 1";

		  $result_set = mysqli_query($connection, $query);

		  if ($result_set) {
		  	if (mysqli_num_rows($result_set)==1){
		  		$errors[] = '- Email Address already exists';
		  	}
		}
			if (empty($errors)) {
			//no erros found... adding new record
			 $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
			 $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
			 $password = mysqli_real_escape_string($connection, $_POST['password']);

			 $hashed_password = sha1($password);

	 			$query = "INSERT INTO user (";
	 			$query .="first_name, last_name, email,password, is_deleted";
	 			$query .=")VALUES(";
	 			$query .= "'{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}',0";
	 			$query .=")";

				 $result = mysqli_query($connection, $query);

				 if ($result) {
				//query succesful... redirecting to index page
				header('Location: index.php ?user added = true');
	
				}else {
				$errors[] = 'Failed to add new record';
			}

		}
	} 

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add New User</title>
	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
<header>
		<div class="appname">User Management System</div>	
		

	</header>

	<main>	
		<h1>Sign Up</h1><a href="index.php"> <h3> <<< Back to Login</h3></a><hr>
		<?php 

		if (!empty($errors)) {
			echo '<div class = "errmsg">';

			echo '<b>There were error(s) on your form </b><br>';
			foreach ($errors as $error) {
					echo $error .'<br>';
		
			}

			echo '</div>';
		}



		 ?>



		<form action="add-user.php" method = "POST" class="userform">
			<p>
				<label for="">First Name:</label>
				<input type="text" name="first_name"<?php echo 'value="' . $first_name . '"';?>>
			</p>

			<p>
				<label for="">Last Name:</label>
				<input type="text" name="last_name"<?php echo 'value="' . $last_name . '"';?>>
			</p>

			<p>
				<label for="">Email Address:</label>
				<input type="text"name="email"<?php echo 'value="' . $email . '"';?>>

			</p>

			<p>
				<label for="">Password</label>
				<input type="text" name = "password">

			</p>

			<p>
				<label for="">&nbsp;</label>
				<button type="submit" name="submit">Create Account</button>

			</p>
		</form>
	</main>
</body>
</html>