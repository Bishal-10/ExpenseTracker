<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'expensetracker');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $cost = $_POST['cost'];

    // Validate input
    if (!empty($id) && !empty($title) && !empty($category) && !empty($cost)) {
        // Prepare the update query
        $query = "UPDATE expenses SET title = ?, category = ?, cost = ? WHERE id = ? AND username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssdss', $title, $category, $cost, $id, $_SESSION['username']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: history.php"); // Redirect back to history page
            exit();
        } else {
            echo "Failed to update the transaction.";
        }

        $stmt->close();
    } else {
        echo "Invalid request. All fields are required.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
