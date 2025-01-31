<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php include 'header.php'; ?>
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