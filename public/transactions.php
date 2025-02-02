<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f4ff;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .navbar {
            display: flex;
            background-color: #333;
            padding: 10px;
            justify-content: left;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
        }
        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: left;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(54, 26, 218, 0.83);
            overflow: hidden;
            width: 100%;
            margin-top: 60px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin: 20px 0;
        }
        .summary div {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 48%;
            text-align: center;
        }
        .chart-container {
            width: 100%;
            max-width: 600px;
            margin: 20px 0;
        }
        .chart-container canvas {
            width: 100%;
            height: auto;
        }
        ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
            max-width: 1200px;
        }
        ul li {
            background-color: #f4f4f4;
            margin: 10px 0;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="add_transaction.php">Tambah</a>
            <a href="transactions.php">View Transactions</a>
        <?php endif; ?>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php else: ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <h1>Transactions</h1>
        <div class="summary">
            <div>
                <h2>Total Transactions This Month</h2>
                <p id="total-transactions">Loading...</p>
            </div>
            <div>
                <h2>Total Amount This Month</h2>
                <p id="total-amount">Loading...</p>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="categoryChart"></canvas>
        </div>
        <ul>
            <?php
            $conn = new mysqli("localhost", "root", "", "finance_db");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $user_id = $_SESSION['user_id'];
            $sql = "SELECT id, amount, date, note FROM transactions WHERE user_id='$user_id'";
            $result = $conn->query($sql);

            $transactions = [];
            $totalAmount = 0;
            $totalTransactions = 0;

            if ($result) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $transactions[] = $row;
                        $totalAmount += $row["amount"];
                        $totalTransactions++;
                        echo "<li>" . $row["date"] . " - Rp" . number_format($row["amount"], 2, ',', '.') . " - " . $row["note"] . "</li>";
                    }
                } else {
                    echo "0 results";
                }
            } else {
                echo "Error: " . $conn->error;
            }

            $conn->close();
            ?>
        </ul>
    </div>
    <script>
        document.getElementById('total-transactions').innerText = '<?php echo $totalTransactions; ?>';
        document.getElementById('total-amount').innerText = 'Rp<?php echo number_format($totalAmount, 2, ',', '.'); ?>';

        const transactions = <?php echo json_encode($transactions); ?>;
        const categories = {};
        transactions.forEach(transaction => {
            const category = transaction.note || 'Uncategorized';
            if (!categories[category]) {
                categories[category] = 0;
            }
            categories[category] += parseFloat(transaction.amount);
        });

        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(categories),
                datasets: [{
                    label: 'Transaction Categories',
                    data: Object.values(categories),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Transaction Categories'
                    }
                }
            }
        });
    </script>
</body>
</html>