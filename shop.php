<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

// Cek koneksi database
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data
$query = "SELECT id_paket, nama_paket, venue, image, deskripsi FROM paket";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detik Photography - Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/header.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 100px auto 40px;
            padding: 0 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-content {
            padding: 25px;
            background: #f8f8f8;
        }

        .card-title {
            font-size: 18px;
            color: #333;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .card-description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            height: 80px;
            overflow: hidden;
        }

        .location {
            display: flex;
            align-items: center;
            color: #888;
            font-size: 14px;
            margin-top: 15px;
        }

        .location:before {
            content: "📍";
            margin-right: 5px;
        }

        @media (max-width: 992px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .grid {
                grid-template-columns: 1fr;
            }
            .nav-links {
                display: none;
            }
        }
    </style>
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
                <a href="login.php">
                    <img src="photos/icons/profile.png" alt="login bangg">
                </a>
            </div>

        </div>
    </header>
    <div class="container">
        <div class="grid">
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) { 
            ?>
                <div class="card" onclick="window.location.href='booking.php?id_paket=<?php echo $row['id_paket']; ?>';" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" 
                             alt="<?php echo htmlspecialchars($row['nama_paket']); ?>">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title"><?php echo htmlspecialchars($row['nama_paket']); ?></h3>
                        <p class="card-description"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                        <div class="location">
                            <?php echo htmlspecialchars($row['venue']); ?>
                        </div>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<p>Tidak ada paket yang tersedia</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
