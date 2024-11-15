<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    }
    $error = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/header.css">
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
    <header>
        <div class="front-header">
            <p><a href="index.php">Detik Photography</a></p>
        </div>
        <div class="middle-header">
            <div>
                <a href="index.php">Home</a>
            </div>
            <div>
                <a href="gallery.php">Gallery</a>
            </div>
            <div>
                <a href="shop.php">Shop</a>
            </div>
            <div>
                <a href="about_us.php">About Us</a>
            </div>
        </div>
        <div class="back-header">
            <div>
                <img src="photos/icons/cart.png" alt="">
            </div>
            <div>
                <img src="photos/icons/profile.png" alt="">
            </div>

        </div>
    </header>
    <div class="container">
        <div class="login-box">
            <div class="login-form">
                <h2>Login</h2>
                <?php if (isset($error)) { ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username or email</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="options">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="forgot">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="login-btn">Login</button>
                </form>
                
                <div class="signup-link">
                    Belum punya akun? <a href="signup.php">Sign up</a>
                </div>
                
                <div class="social-login">
                    <p>Atau login dengan</p>
                    <div class="social-buttons">
                        <button class="social-btn">Google</button>
                        <button class="social-btn">Facebook</button>
                    </div>
                </div>
            </div>
            <div class="login-image">
                <img src="photos/img/ftgr1.jpeg" alt="Photographer">
            </div>
        </div>
    </div>
</body>
</html>