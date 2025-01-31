<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php include 'header.php'; ?>
    <h1>Transactions</h1>
    <ul>
        <?php
        $conn = new mysqli("localhost", "root", "", "finance_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT id, amount, date, note FROM transactions WHERE user_id='$user_id'";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
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
</body>
</html>