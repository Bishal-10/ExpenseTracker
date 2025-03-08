<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'expensetracker');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch transactions for the logged-in user
$username = $_SESSION['username'];
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

// Default to current month's transactions if no filters are set
if (empty($from_date) && empty($to_date)) {
    $from_date = date('Y-m-01'); // First day of the current month
    $to_date = date('Y-m-t'); // Last day of the current month
}

// Prepare query with date range filter
$query = "SELECT * FROM expenses WHERE username = ? AND DATE(transaction_date) BETWEEN ? AND ? ORDER BY transaction_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $username, $from_date, $to_date);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body {
            background-color: #b5cfb7;
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #e7e8d8;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #bc9f8b;
            color: white;
        }
        .filter-form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .filter-form input, .filter-form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .filter-form button {
            background-color: #C4E264;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .filter-form button:hover {
            background-color: #a2c14f;
        }
        .dashboard-btn {
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color:rgb(14, 73, 128);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .dashboard-btn:hover {
            background-color: #5aa2e0;
        }
        .edit-btn {
            background-color: #ffcc00;
            padding: 5px;
            border-radius:4px;

        }
        .delete-btn {
            background-color: #ff6666;
            padding: 5px;
            border-radius:4px;
        }
        .edit-section {
            display: none;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            background-color: #e7e8d8;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Transaction History</h1>
        <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Return to Dashboard</button>

        <!-- Filter Form -->
        <form method="get" class="filter-form">
            <input type="date" name="from_date" value="<?php echo htmlspecialchars($from_date); ?>" placeholder="From Date">
            <input type="date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>" placeholder="To Date">
            <button type="submit">Filter</button>
        </form>

        <!-- Transactions Table -->
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Cost</th>
                  
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                            <td><?php echo htmlspecialchars($row['cost']); ?></td>
                          
                            <td>
                                <button class="edit-btn" onclick="showEditSection(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['title']); ?>', '<?php echo htmlspecialchars($row['category']); ?>', '<?php echo htmlspecialchars($row['cost']); ?>')">Edit</button>
                                <button class="delete-btn" onclick="deleteTransaction(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No transactions found for this date range.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Edit Section -->
        <div id="edit-section" class="edit-section">
            <form method="post" action="edit.php">
                <input type="hidden" name="id" id="edit-id">
                <label>Title:</label>
                <input type="text" name="title" id="edit-title" required>
                <label>Category:</label>
                <select name="category" id="edit-category" required>
                    <option value="food">Food</option>
                    <option value="clothes">Clothes</option>
                    <option value="education">Education</option>
                    <option value="transportation">Transportation</option>
                    <option value="others">Others</option>
                </select>
                <label>Cost:</label>
                <input type="number" name="cost" id="edit-cost" required>
                <button type="submit">Save</button>
                <button type="button" onclick="hideEditSection()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function showEditSection(id, title, category, cost) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-category').value = category;
            document.getElementById('edit-cost').value = cost;
            document.getElementById('edit-section').style.display = 'block';
        }

        function hideEditSection() {
            document.getElementById('edit-section').style.display = 'none';
        }

        function deleteTransaction(id) {
            if (confirm('Are you sure you want to delete this transaction?')) {
                window.location.href = `delete.php?id=${id}`;
            }
        }
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
