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

// Get filter dates if set, else set default values (e.g., last month)
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01'); // Default to the 1st of the current month
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t'); // Default to the last day of the current month

// Fetch category-wise expense data for the logged-in user with date range filter
$username = $_SESSION['username'];
$query = "SELECT category, SUM(cost) as total_cost FROM expenses WHERE username = ? AND transaction_date BETWEEN ? AND ? GROUP BY category";

$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $username, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

$data = [["Category", "Total Cost"]]; // Initialize data for the chart
while ($row = $result->fetch_assoc()) {
    $data[] = [$row['category'], (float)$row['total_cost']];
}

// Close database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Report</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Google Charts library
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Prepare data for the chart
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

            // Chart options
            var options = {
                title: "Expenses by Category",
                pieHole: 0.2, 
                colors: ["red", "blue", "green", "yellow", "orange"],
                backgroundColor: "#f2f2f2"
            };

            // Render the chart
            var chart = new google.visualization.PieChart(document.getElementById("piechart"));
            chart.draw(data, options);
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b5cfb7;
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: center;
            padding: 20px;
        }
        
        #piechart {
            width: 100%;
            max-width: 900px;
            height: 470px;
            margin: 0 auto;
        }
        
        .dashboard-btn {
            margin-top: 20px;
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

        .filter-form {
            margin: 20px 0;
        }

        .filter-form input {
            padding: 5px;
            font-size: 14px;
        }

        .filter-form button {
            padding: 5px 10px;
            font-size: 14px;
            background-color: rgb(14, 73, 128);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #5aa2e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Expense Report</h1>

        <!-- Filter Form -->
        <form action="reports.php" method="post" class="filter-form">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>" required>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>" required>
            <button type="submit">Filter</button>
        </form>

        <!-- Google Chart -->
        <div id="piechart"></div>
        <button class="dashboard-btn" onclick="window.location.href='dashboard.php'">Return to Dashboard</button>
    </div>
</body>
</html>
