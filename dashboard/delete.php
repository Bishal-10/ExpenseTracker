<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die('Unauthorized access.');
}

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'expensetracker');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if transaction ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Transaction ID is required.');
}

$transaction_id = intval($_GET['id']);
$username = $_SESSION['username'];

// Ensure the transaction belongs to the logged-in user
$query = "DELETE FROM expenses WHERE id = ? AND username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('is', $transaction_id, $username);

if ($stmt->execute()) {
    header("Location: history.php"); // Redirect back to history page
    exit();
} else {
    echo 'Failed to delete transaction.';
}

$stmt->close();
$conn->close();
?>
