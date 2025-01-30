<!-- filepath: /D:/finance-tracker/public/add_transaction.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
</head>
<body>
    <h1>Add Transaction</h1>
    <form action="add_transaction.php" method="POST">
        <div>
            <label>Amount:</label>
            <input type="number" name="amount" required>
        </div>
        <div>
            <label>Date:</label>
            <input type="date" name="date" required>
        </div>
        <div>
            <label>Note:</label>
            <input type="text" name="note">
        </div>
        <button type="submit">Add</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $note = $_POST['note'];

        $conn = new mysqli("localhost", "root", "", "db_finance");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO transactions (amount, date, note) VALUES ('$amount', '$date', '$note')";

        if ($conn->query($sql) === TRUE) {
            echo "New transaction added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>