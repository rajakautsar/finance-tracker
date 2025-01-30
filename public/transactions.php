<!-- filepath: /D:/finance-tracker/public/transactions.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
</head>
<body>
    <h1>Transactions</h1>
    <ul>
        <?php
        $conn = new mysqli("localhost", "root", "", "db_finance");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, amount, date, note FROM transactions";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li>" . $row["date"] . " - $" . $row["amount"] . " - " . $row["note"] . "</li>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </ul>
</body>
</html>