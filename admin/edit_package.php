<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config.php';

if (!isset($_GET['id_paket'])) {
    header("Location: package.php");
    exit();
}

$id_paket = $_GET['id_paket'];

// Query untuk mengambil data paket
$query_paket = "SELECT * FROM paket WHERE id_paket = ?";
$stmt = mysqli_prepare($conn, $query_paket);
mysqli_stmt_bind_param($stmt, "i", $id_paket);
mysqli_stmt_execute($stmt);
$result_paket = mysqli_stmt_get_result($stmt);
$paket = mysqli_fetch_assoc($result_paket);

// Query untuk mengambil semua versi paket
$query_versi = "SELECT * FROM versi_paket WHERE id_paket = ?";
$stmt = mysqli_prepare($conn, $query_versi);
mysqli_stmt_bind_param($stmt, "i", $id_paket);
mysqli_stmt_execute($stmt);
$result_versi = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Package Details - Detik Photography</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/header.css">
    
    <style>
        body {
            background-color: #E5DDD5;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1000px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 10px;
        }

        .package-title {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }

        .package-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }

        .package-image {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
        }

        .package-image img {
            width: 100%;
            height: auto;
        }

        .package-info {
            margin-top: 20px;
        }

        .description {
            margin-bottom: 20px;
        }

        .description h3, .location-price h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
        }

        .location-price {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 10px;
            align-items: center;
        }

        .version-details {
            margin-top: 30px;
        }

        .version-block {
            margin-bottom: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .version-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .version-label {
            padding: 5px 20px;
            border-radius: 15px;
            color: white;
            font-weight: 500;
        }

        .bronze { background-color: #8B4513; }
        .silver { background-color: #C0C0C0; }
        .gold { background-color: #FFD700; color: black; }

        .edit-btn {
            background-color: #008000;
            color: white;
            padding: 5px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .details-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .details-list li {
            margin-bottom: 8px;
            font-size: 14px;
            color: #666;
        }

        .delete-btn {
            background-color: #FF0000;
            color: white;
            padding: 8px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header sama seperti sebelumnya -->

    <div class="container">
        <h1 class="package-title">Package Details</h1>
        
        <div class="package-content">
            <div class="package-left">
                <div class="package-image">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($paket['image']); ?>" 
                         alt="<?php echo htmlspecialchars($paket['nama_paket']); ?>">
                </div>
                
                <div class="package-info">
                    <h2><?php echo htmlspecialchars($paket['nama_paket']); ?></h2>
                    
                    <div class="description">
                        <h3>Description :</h3>
                        <p><?php echo htmlspecialchars($paket['deskripsi']); ?></p>
                    </div>
                    
                    <div class="location-price">
                        <h3>Location</h3>
                        <p>: <?php echo htmlspecialchars($paket['venue']); ?></p>
                        <h3>Price</h3>
                        <p>: Rp <?php echo number_format($paket['harga_paket'], 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>

            <div class="version-details">
                <h3>Details :</h3>
                <?php 
                while($versi = mysqli_fetch_assoc($result_versi)) {
                    $version_class = strtolower($versi['nama_versi']);
                ?>
                    <div class="version-block">
                        <div class="version-header">
                            <span class="version-label <?php echo $version_class; ?>">
                                <?php echo $versi['nama_versi']; ?>
                            </span>
                            <a href="edit_version.php?id=<?php echo $versi['id_versi_paket']; ?>" 
                               class="edit-btn">EDIT</a>
                        </div>
                        
                        <ul class="details-list">
                            <li>Durasi Pemotretan: <?php echo $versi['durasi_pemotretan']; ?></li>
                            <li>DVD/FlashDisk: <?php echo $versi['dvd_flashdisk'] ? 'Ya' : 'Tidak'; ?></li>
                            <li>Photobook: <?php echo $versi['ukuran_photobook']; ?> 
                                (<?php echo $versi['isi_photobook']; ?> halaman)</li>
                            <li>MUA & Hairdo: <?php echo $versi['mua_hairdo'] ? 'Ya' : 'Tidak'; ?></li>
                        </ul>
                    </div>
                <?php } ?>
                
                <a href="delete_package.php?id=<?php echo $id_paket; ?>" 
                   class="delete-btn" 
                   onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">DELETE</a>
            </div>
        </div>
    </div>
</body>
</html>
