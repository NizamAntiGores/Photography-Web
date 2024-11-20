<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

if (!isset($_GET['id_paket'])) {
    header("Location: shop.php");
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

// Query untuk mengambil data versi paket
$query_versi = "SELECT * FROM versi_paket WHERE id_paket = ?";
$stmt = mysqli_prepare($conn, $query_versi);
mysqli_stmt_bind_param($stmt, "i", $id_paket);
mysqli_stmt_execute($stmt);
$result_versi = mysqli_stmt_get_result($stmt);
$versi_paket = [];
while ($row = mysqli_fetch_assoc($result_versi)) {
    $versi_paket[$row['nama_versi']] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking - Detik Photography</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style/general.css">
    <link rel="stylesheet" href="style/header.css">
    <style>
 

        .booking-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 40px;
            background-color: #f5f5f5;
            border-radius: 10px;
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .back-button:before {
            content: "←";
            font-size: 20px;
        }

        .booking-image {
            width: 100%;
        }

        .booking-image img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .total-payment {
            background-color: #f0e6e6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .total-payment h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #333;
        }

        #total-price {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .checkout-btn {
            background-color: #006400;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            width: 100%;
        }

        .version-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .version-btn {
            padding: 8px 25px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            transition: opacity 0.3s;
        }

        .version-btn:hover {
            opacity: 0.9;
        }

        .bronze { background-color: #8B4513; color: white; }
        .silver { background-color: #C0C0C0; color: white; }
        .gold { background-color: #FFD700; color: black; }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #E5DDD5;
            font-size: 14px;
        }

        .form-group input[readonly] {
            background-color: #E5DDD5;
            color: #666;
        }

        .syarat-ketentuan {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }

        .syarat-ketentuan h4 {
            margin-bottom: 10px;
            color: #333;
        }

        .syarat-ketentuan ul {
            list-style: none;
            padding-left: 0;
        }

        .syarat-ketentuan li {
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .booking-container {
                grid-template-columns: 1fr;
                padding: 20px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header sama seperti shop.php -->
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

    <div class="booking-container">
        <div class="booking-image">
            <a href="shop.php" class="back-button">Booking Info</a>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($paket['image']); ?>" 
                 alt="<?php echo htmlspecialchars($paket['nama_paket']); ?>">
            
            <div class="total-payment">
                <h3>Total Pembayaran</h3>
                <p id="total-price">Rp 0</p>
                <button class="checkout-btn">Checkout</button>
            </div>

            <div class="syarat-ketentuan">
                <h4>*Syarat dan ketentuan</h4>
                <ul>
                    <li>1. Lorem ipsum dolor sit amet, consectetur</li>
                    <li>2. Lorem ipsum dolor sit amet, consectetur</li>
                    <li>3. Lorem ipsum dolor sit amet, consectetur</li>
                </ul>
            </div>
        </div>

        <div class="booking-form">
            <div class="version-buttons">
                <button class="version-btn bronze" onclick="selectVersion('Bronze')">Bronze</button>
                <button class="version-btn silver" onclick="selectVersion('Silver')">Silver</button>
                <button class="version-btn gold" onclick="selectVersion('Gold')">Gold</button>
            </div>

            <form id="bookingForm">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>No. HP</label>
                    <input type="tel" name="phone" required>
                </div>

                <div class="form-group">
                    <label>Paket Pemotretan</label>
                    <input type="text" value="<?php echo htmlspecialchars($paket['nama_paket']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Durasi Pemotretan</label>
                    <input type="text" id="durasi" readonly>
                </div>

                <div class="form-group">
                    <label>Tanggal Pemotretan</label>
                    <input type="date" name="tanggal" required>
                </div>

                <div class="form-group">
                    <label>DVD / Flash Disk</label>
                    <input type="text" id="dvd" readonly>
                </div>

                <div class="form-group">
                    <label>Photo Book</label>
                    <input type="text" id="photobook" readonly>
                </div>

                <div class="form-group">
                    <label>MUA & Hairdo</label>
                    <input type="text" id="mua" readonly>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Menyimpan data versi paket dari PHP ke JavaScript
        const versiPaket = <?php echo json_encode($versi_paket); ?>;

        function selectVersion(version) {
            const data = versiPaket[version];
            if (data) {
                document.getElementById('durasi').value = data.durasi_pemotretan;
                document.getElementById('dvd').value = data.dvd_flashdisk ? 'Ya' : 'Tidak';
                document.getElementById('photobook').value = `${data.ukuran_photobook} (${data.isi_photobook} halaman)`;
                document.getElementById('mua').value = data.mua_hairdo ? 'Ya' : 'Tidak';
                document.getElementById('total-price').textContent = 
                    `Rp ${new Intl.NumberFormat('id-ID').format(data.harga_versi_paket)}`;
            }
        }
    </script>
</body>
</html>
