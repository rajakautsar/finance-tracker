<?php
session_start();
$conn = new mysqli("localhost", "root", "", "finance_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Account created successfully. <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f4ff; /* Warna latar belakang biru muda */
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
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
            max-width: 600px; /* Ukuran diperbesar */
            width: 90%;
            margin-top: 60px; /* Tambahkan margin untuk memberi jarak dari navbar */
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 20px 0;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-container input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%; /* Pastikan input mengambil lebar penuh */
            box-sizing: border-box; /* Pastikan padding dan border dihitung dalam lebar */
        }
        .form-container button {
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #555;
        }
    </style>
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
        <h1>Register</h1>
        <div class="form-container">
            <form action="register.php" method="POST">
                <div>
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label>Confirm Password:</label>
                    <input type="password" name="confirm_password" required>
                </div>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>