<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'expensetracker');  // Make sure these match your DB credentials

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Query to find user with matching username and password
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Login success: Fetch the user and set session variables
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user['username'];  // Store username in session
        header("Location: ../dashboard/dashboard.php");  // Redirect to dashboard
        exit();
    } else {
        // Invalid credentials
        $_SESSION['msg'] = "Invalid username or password!";
        header("Location: login.php");
        exit();
    }
}
?>
