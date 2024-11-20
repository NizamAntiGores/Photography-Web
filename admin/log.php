<?php
require_once('../config.php');

// Query untuk mengambil data pemesanan lengkap dengan detail versi paket
$query = "SELECT 
    t.id_transaksi,
    k.nama_klien as name,
    k.alamat_klien,
    p.nama_paket as package,
    vp.nama_versi as package_ver,
    vp.durasi_pemotretan as duration,
    vp.dvd_flashdisk as dvd,
    vp.ukuran_photobook as photobook_size,
    vp.isi_photobook as photobook_pages,
    vp.mua_hairdo as mua,
    t.tanggal_pembelian as date,
    t.jumlah as amount,
    t.total_pembayaran as total,
    pb.metode_pembayaran as payment
FROM transaksi t
JOIN klien k ON t.id_klien = k.id_klien
JOIN paket p ON t.id_paket = p.id_paket
JOIN versi_paket vp ON t.id_versi_paket = vp.id_versi_paket
JOIN pembayaran pb ON t.id_transaksi = pb.id_transaksi
ORDER BY t.tanggal_pembelian DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Pesanan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
        }
        .log-title {
            margin-bottom: 20px;
        }
        .package-details {
            font-size: 12px;
            color: #666;
        }
        .payment-info {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 class="log-title">Log Pesanan</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Informasi Klien</th>
                <th>Detail Paket</th>
                <th>Spesifikasi Paket</th>
                <th>Informasi Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id_transaksi']; ?></td>
                
                <td>
                    <strong><?php echo $row['name']; ?></strong><br>
                    <?php echo $row['alamat_klien']; ?>
                </td>
                
                <td>
                    <strong><?php echo $row['package']; ?></strong><br>
                    Versi: <?php echo $row['package_ver']; ?>
                </td>
                
                <td>
                    <ul style="margin: 0; padding-left: 15px;">
                        <li>Durasi: <?php echo $row['duration']; ?></li>
                        <li>DVD/Flashdisk: <?php echo $row['dvd'] ? 'Ya' : 'Tidak'; ?></li>
                        <li>Ukuran Photobook: <?php echo $row['photobook_size']; ?></li>
                        <li>Halaman Photobook: <?php echo $row['photobook_pages']; ?> halaman</li>
                        <li>MUA & Hairdo: <?php echo $row['mua'] ? 'Ya' : 'Tidak'; ?></li>
                    </ul>
                </td>
                
                <td>
                    <div class="payment-info">
                        Total: Rp <?php echo number_format($row['total'], 0, ',', '.'); ?><br>
                        Metode: <?php echo $row['payment']; ?>
                    </div>
                </td>
                
                <td><?php echo date('d/m/Y', strtotime($row['date'])); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
