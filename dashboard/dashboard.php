<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

// Fetch the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
            <div class="greeting">
                <p>Dear <?php echo htmlspecialchars($username); ?>!</p> <!-- Display the username -->
            </div>
            <div class="logo">
                <img src="../images/a-minimal-black-and-white-logo-with-a-stylized-ima-ummsoNe7Q1e7eABCChvDoA-dD8ZRugKQgGhmayfYELtBg.jpeg" alt="Logo">
                <span>Expense Tracker</span>
            </div>
            <div class="user-icon" onclick="userAction()">&#128100;</div>
        </header>

        <!-- Sidebar Menu -->
        <nav id="sidebar-menu" class="sidebar">
            <div class="close-icon" onclick="toggleMenu()">&#10005;</div> <!-- Close icon -->
            <a href="#" class="menu-item">
                <span class="icon">&#127968;</span> Home
            </a>
            <a href="#" class="menu-item">
                <span class="icon">&#128197;</span> History
            </a>
            <a href="#" class="menu-item">
                <span class="icon">&#9998;</span> Reports
            </a>
            <a href="#" class="menu-item logout">Logout</a>
        </nav>

        <!-- Main Content -->
        <main class="main-content" onclick="closeMenuIfOpen()">
            <!-- Left Section -->
            <section class="summary">
                <div class="summary-box">
                    <p>Expenses:</p>
                    <div class="value">XXX.XXX</div>
                </div>
                <div class="summary-box">
                    <p>Budget:</p>
                    <div class="value">XXX.XXX</div>
                </div>
            </section>

            <!-- Right Section -->
            <section class="transaction-form">
                <h2>Add New Transaction</h2>
                <form>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title">
                    <label for="category">Category:</label>
                    <input type="text" id="category" name="category">
                    <label for="cost">Cost:</label>
                    <input type="number" id="cost" name="cost">
                    <button type="submit">Add Transaction</button>
                </form>
            </section>
        </main>
    </div>

    <script>
        const menu = document.getElementById('sidebar-menu');

        function toggleMenu() {
            menu.classList.toggle('active');
        }

        function closeMenuIfOpen() {
            if (menu.classList.contains('active')) {
                menu.classList.remove('active');
            }
        }

        function userAction() {
            alert('User icon clicked! Add further actions here.');
        }
    </script>
</body>
</html>
