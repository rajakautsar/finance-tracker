<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f4ff; /* Warna latar belakang biru muda */
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
            width: 100%; /* Memenuhi lebar penuh */
            margin-top: 60px; /* Tambahkan margin untuk memberi jarak dari navbar */
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px; /* Sesuaikan lebar maksimum */
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
            max-width: 220px; /* Sesuaikan ukuran chart */
            margin: 20px 0;
        }
        .chart-container canvas {
            width: 100%; /* Sesuaikan ukuran canvas */
            height: auto;
        }
        ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
            max-width: 1200px; /* Sesuaikan lebar maksimum */
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