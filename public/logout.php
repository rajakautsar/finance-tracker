<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
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
        <h1>Logout</h1>
        <p>You have been logged out. <a href="login.php">Login again</a></p>
    </div>
</body>
</html>