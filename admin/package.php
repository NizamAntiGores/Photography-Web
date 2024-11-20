<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config.php';

// Query untuk mengambil data paket
$query = "SELECT id_paket, nama_paket, deskripsi, image FROM paket";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detik Photography - Package</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/header.css">
    
    <style>
        body {
            background-color: #E5DDD5;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 100px auto;
            padding: 20px;
        }

        .shop-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .package-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .package-item {
            display: flex;
            background-color: #f5f5f5;
            border-radius: 10px;
            overflow: hidden;
            padding: 15px;
            align-items: center;
            gap: 20px;
        }

        .package-image {
            width: 200px;
            height: 120px;
            overflow: hidden;
            border-radius: 8px;
        }

        .package-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .package-info {
            flex: 1;
        }

        .package-name {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .package-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .package-details-btn {
            background-color: #3B3BFF;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .package-details-btn:hover {
            opacity: 0.9;
        }

        .add-btn {
            background-color: #008000;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 30px;
            float: right;
        }

        .add-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <!-- <header>
        <div class="front-header">
            <p><a href="index.php">Detik Photography</a></p>
        </div>
        <div class="middle-header">
            <div><a href="index.php">Home</a></div>
            <div><a href="gallery.php">Gallery</a></div>
            <div><a href="shop.php">Shop</a></div>
            <div><a href="about_us.php">About Us</a></div>
            <div><a href="modify.php">Modify</a></div>
            <div><a href="log.php">Log</a></div>
        </div>
        <div class="back-header">
            <div><img src="photos/icons/profile.png" alt=""></div>
        </div>
    </header> -->

    <div class="container">
        
        <div class="package-list">
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <div class="package-item">
                    <div class="package-image">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" 
                             alt="<?php echo htmlspecialchars($row['nama_paket']); ?>">
                    </div>
                    <div class="package-info">
                        <h3 class="package-name"><?php echo htmlspecialchars($row['nama_paket']); ?></h3>
                        <p class="package-description"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                        <a href="edit_package.php?id_paket=<?php echo $row['id_paket']; ?>" 
                           class="package-details-btn">package details</a>
                    </div>
                </div>
            <?php } ?>
        </div>

        <a href="add_package.php" class="add-btn">ADD</a>
    </div>
</body>
</html>
