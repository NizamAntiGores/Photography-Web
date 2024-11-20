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
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Detik Photography</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../gallery.php">Gallery</a></li>
                <li><a href="../shop.php">Shop</a></li>
                <li><a href="../about_us.php">About Us</a></li>
                <li><a href="modify.php">Modify</a></li>
                <li><a href="log.php">Log</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Selamat datang, Admin <?php echo $_SESSION['username']; ?>!</h2>
    </main>
</body>
</html> 