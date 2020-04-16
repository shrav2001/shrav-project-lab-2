<?php
session_start();

// initializing variables
$username = "";
$usn = "";
$department = "";
$email    = "";
$phone = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($db, $_POST['password']);
  $department = mysqli_real_escape_string($db, $_POST['department']);
     $usn = mysqli_real_escape_string($db, $_POST['usn']);
     $phone = mysqli_real_escape_string($db, $_POST['phone']);
  
  

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password)) { array_push($errors, "Password is required"); }
     if (empty($confirm_password)) { array_push($errors, "Password should be confirmed"); }
  if ($password!= $confirm_password_2) {
	array_push($errors, "The two passwords do not match");
  }
     if (empty($usn)) { array_push($errors, "Usn is required"); }
     if (empty($department)) { array_push($errors, "Department is required"); }
     if (empty($phone)) { array_push($errors, "Phone number is required"); }
 
 
 

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username'OR phone='$phone'OR usn='$usn' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }
    if ($user) { // if user exists
    if ($user['phone'] === $phone) {
      array_push($errors, "Phone number already exists");
    }
        if ($user) { // if user exists
    if ($user['usn'] === $usn) {
      array_push($errors, "Usn already exists");
    }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}
        // LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>
