<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Password tanpa hash
    $role = 'user'; // Default role adalah user
    
    // Cek apakah username sudah ada
    $check_query = "SELECT * FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $password, $role);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Pendaftaran berhasil! Silakan login.";
            header("Location: login.php");
            exit();
        } else {
            $error = "Terjadi kesalahan! Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Gunakan CSS yang sama seperti login.php -->
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <!-- Header sama seperti login.php -->
    <div class="container">
        <div class="login-box">
            <div class="login-form">
                <h2>Sign Up</h2>
                <?php if (isset($error)) { ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <button type="submit">Daftar</button>
                    <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
                </form>
            </div>
            <div class="login-image">
                <img src="photos/img/ftgr1.jpeg" alt="">
            </div>
        </div>
    </div>
</body>
</html> 