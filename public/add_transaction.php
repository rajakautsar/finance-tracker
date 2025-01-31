<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finance_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php include 'header.php'; ?>
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
        $user_id = $_SESSION['user_id'];

        // Insert data into database
        $sql = "INSERT INTO transactions (amount, date, note, user_id) VALUES ('$amount', '$date', '$note', '$user_id')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>