<?php
    session_start();

    // Database connection
    $con = mysqli_connect('localhost', 'root', '', 'expensetracker');
    if (!$con) {
        echo "Connection failed";
        die;
    } 

    // Ensure user is logged in and username is available
    if (!isset($_SESSION['username'])) {
        echo "User not logged in";
        die;
    }

    $username = $_SESSION['username'];

    // Retrieve data from the form
    $title = $_POST['title'];
    $category = $_POST['category'];
    $cost = $_POST['cost'];

    // Insert into the database
    $sql = "INSERT INTO expenses (title, category, cost, username) VALUES ('$title', '$category', '$cost', '$username')";
    $res = mysqli_query($con, $sql);

    if (!$res) {
        echo "Insert failed";
    } else {
        header("location: ./dashboard.php");
    }
?>
