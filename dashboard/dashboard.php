<?php 
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch the username from the session
$username = $_SESSION['username'];

// Include database connection
$conn = new mysqli("localhost", "root", "", "expensetracker");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$stmt = $conn->prepare("SELECT name, email, phone_number, username FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user_details = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
             <a href="../index.php" style="text-decoration:none; color:black;">  <span>Expense Tracker</span></a>
            </div>
            <div class="user-icon" onclick="toggleUserSidebar()">&#128100;</div>
        </header>

        <!-- Sidebar Menu -->
        <nav id="sidebar-menu" class="sidebar">
            <div class="close-icon" onclick="toggleMenu()">&#10005;</div> <!-- Close icon -->
            <a href="dashboard.php" class="menu-item">
                <span class="icon">&#127968;</span> Home
            </a>
            <a href="./history.php" class="menu-item">
                <span class="icon">&#128197;</span> History
            </a>
            <a href="./reports.php" class="menu-item">
                <span class="icon">&#9998;</span> Reports
            </a>
            <a href="../login/logout.php" class="menu-item logout">Logout</a>
        </nav>

        <!-- User Details Sidebar -->
        <div id="user-sidebar" class="user-sidebar">
            <div class="close-icon" onclick="toggleUserSidebar()">&#10005;</div>
            <h2><?php echo htmlspecialchars($user_details['name']); ?></h2>
            <p class="menu-item">Username: <?php echo htmlspecialchars($user_details['username']); ?></p>
            <p class="menu-item">Email: <?php echo htmlspecialchars($user_details['email']); ?></p>
            <p class="menu-item">Phone Number: <?php echo htmlspecialchars($user_details['phone_number']); ?></p>
            <!-- Add ID to the form to target it with JavaScript -->
            <form id="delete-account-form" action="delete_account.php" method="post" style="margin-top: 20px;">
                <button type="submit" class="delete-account-btn">Delete Account</button>
            </form>
        </div>

        <!-- Main Content -->
        <main class="main-content" onclick="closeMenuIfOpen()">
            <section class="summary">
                <!-- <div class="summary-box">
                    <p>Expenses:</p>
                    <div class="value">XXX.XXX</div>
                </div>
                <div class="summary-box">
                    <p>Budget:</p>
                    <div class="value">XXX.XXX</div>
                </div> -->
            </section>
            <section class="transaction-form">
                <h2>Add New Transaction</h2>
                <form action="expenses.php" method="post">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <option value="food">Food</option>
                        <option value="clothes">Clothes</option>
                        <option value="education">Education</option>
                        <option value="transportation">Transportation</option>
                        <option value="others">Others</option>
                    </select>
                    <label for="cost">Cost:</label>
                    <input type="number" id="cost" name="cost" required>
                    <button type="submit">Add Transaction</button>
                </form>
            </section>
        </main>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('sidebar-menu');
            menu.classList.toggle('active');
        }

        function toggleUserSidebar() {
            const userSidebar = document.getElementById('user-sidebar');
            userSidebar.classList.toggle('active');
        }

        function closeMenuIfOpen() {
            const menu = document.getElementById('sidebar-menu');
            if (menu.classList.contains('active')) {
                menu.classList.remove('active');
            }
        }

        // Function to confirm account deletion before submitting the form
        document.getElementById('delete-account-form').addEventListener('submit', function(event) {
            const confirmDelete = confirm('Are you sure you want to delete your account? This action cannot be undone.');
            if (!confirmDelete) {
                event.preventDefault(); // Prevent form submission if not confirmed
            }
        });
    </script>
</body>
</html> 