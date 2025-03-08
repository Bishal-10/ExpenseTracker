<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "expensetracker");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the user's account
$username = $_SESSION['username'];
$sql = "DELETE FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    // Logout the user and destroy the session
    session_destroy();
    header("Location: ../login/login.php?message=Account deleted successfully.");
} else {
    echo "Error deleting account: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
