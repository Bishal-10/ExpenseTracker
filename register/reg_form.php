<?php
session_start();

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'expensetracker');
if (!$con) {
    $_SESSION['msg'] = "Registration Failed: Unable to connect to database.";
    header('Location: register.php');
    exit();
}

// Collect data from form
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Insert data into the database
$sql = "INSERT INTO register (name, phone_number, email, username, password) VALUES ('$name', '$number', '$email', '$username', '$password')";

if (mysqli_query($con, $sql)) {
    $_SESSION['msg'] = "Registration Successful!";
} else {
    $_SESSION['msg'] = "Registration Failed: " . mysqli_error($con);
}

// Redirect back to the registration page
header('Location: register.php');
?>
