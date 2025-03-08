<?php
session_start();

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'expensetracker');
if (!$con) {
    $_SESSION['msg'] = "Registration Failed: Unable to connect to the database.";
    header('Location: register.php');
    exit();
}

// Collect data from form and sanitize inputs
$name = mysqli_real_escape_string($con, $_POST['name']);
$number = mysqli_real_escape_string($con, $_POST['number']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$username = mysqli_real_escape_string($con, $_POST['username']);
$password = mysqli_real_escape_string($con, $_POST['password']);

// Check for duplicate username
$usernameCheckQuery = "SELECT * FROM users WHERE username = '$username'";
$usernameCheckResult = mysqli_query($con, $usernameCheckQuery);

if (mysqli_num_rows($usernameCheckResult) > 0) {
    $_SESSION['msg'] = "Registration Failed: Username already taken.";
    header('Location: register.php');
    exit();
}

// Check for duplicate email
$emailCheckQuery = "SELECT * FROM users WHERE email = '$email'";
$emailCheckResult = mysqli_query($con, $emailCheckQuery);

if (mysqli_num_rows($emailCheckResult) > 0) {
    $_SESSION['msg'] = "Registration Failed: Email already registered.";
    header('Location: register.php');
    exit();
}
// Check for duplicate phone number
$numberCheckQuery = "SELECT * FROM users WHERE phone_number = '$number'";
$numberCheckResult = mysqli_query($con, $numberCheckQuery);

if (mysqli_num_rows($numberCheckResult) > 0) {
    $_SESSION['msg'] = "Registration Failed: Number already registered.";
    header('Location: register.php');
    exit();
}

// Insert data into the database
$sql = "INSERT INTO users (name, phone_number, email, username, password) 
        VALUES ('$name', '$number', '$email', '$username', '$password')";

if (mysqli_query($con, $sql)) {
    $_SESSION['msg'] = "Registration Successful!";
} else {
    $_SESSION['msg'] = "Registration Failed: " . mysqli_error($con);
}

// Redirect back to the registration page
header('Location: register.php');
exit();
?> 