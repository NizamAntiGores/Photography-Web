<?php
session_start();
require_once '../config.php';

// Cek apakah user sudah login dan rolenya admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Selamat datang, Admin <?php echo $_SESSION['username']; ?>!</h1>
    <a href="../logout.php">Logout</a>
</body>
</html> 