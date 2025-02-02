<?php
session_start();
$conn = new mysqli("localhost", "root", "", "finance_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$accountCreated = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT id FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error = "Username already exists. Please choose a different username.";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            $accountCreated = true;
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
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
    <script>
        function showPopup() {
            alert('Akun berhasil dibuat. Login disini.');
            window.location.href = 'login.php';
        }
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Register</h1>
        <div class="form-container">
            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
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
    <?php if ($accountCreated): ?>
        <script>
            showPopup();
        </script>
    <?php endif; ?>
</body>
</html>
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