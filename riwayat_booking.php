<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
// Ambil data booking berdasarkan user yang sedang login
$query = mysqli_query($conn, "SELECT booking.*, lapangan.nama_lapangan, lapangan.jenis_lapangan 
                              FROM booking 
                              JOIN lapangan ON booking.id_lapangan = lapangan.id 
                              WHERE booking.id_user = '$id_user' 
                              ORDER BY booking.id_booking DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Booking - FutsalBook</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .riwayat-container { max-width: 950px; margin: 40px auto; padding: 0 20px; }
        .table-booking { width: 100%; border-collapse: collapse; background: #16231e; border-radius: 8px; overflow: hidden; border: 1px solid #293b32; }
        .table-booking th, .table-booking td { padding: 15px; text-align: left; border-bottom: 1px solid #293b32; font-size: 14px; color: #ccc; }
        .table-booking th { background: #101a17; color: #b7ff38; font-weight: 700; }
        .status-badge { background: #25d366; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; }
    </style>
</head>
<body>
    <header>
        <div class="logo">FUTSAL<span>BOOK</span></div>
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="riwayat_booking.php">Riwayat Booking</a>
            <a href="logout.php" style="color: #ff4d4d;">Logout</a>
        </nav>
    </header>

    <div class="riwayat-container">
        <h2>Riwayat Lapangan yang Telah Anda Booking</h2>
        <p class="subtitle" style="margin-bottom: 30px;">Daftar jadwal pertandingan dan lapangan yang berhasil dipesan</p>

        <table class="table-booking">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lapangan</th>
                    <th>Pemesan</th>
                    <th>Tanggal Main</th>
                    <th>Waktu (Jam)</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($query) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) {
                        // Menghitung jam selesai berdasarkan jam mulai + durasi jam
                        $jam_mulai = date('H:i', strtotime($row['jam_mulai']));
                        $jam_selesai = date('H:i', strtotime($row['jam_mulai'] . ' + ' . $row['durasi_jam'] . ' hours'));
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><strong><?php echo htmlspecialchars($row['nama_lapangan']); ?></strong><br><small><?php echo htmlspecialchars($row['jenis_lapangan']); ?></small></td>
                    <td><?php echo htmlspecialchars($row['nama_pemesan']); ?><br><small><?php echo htmlspecialchars($row['no_hp']); ?></small></td>
                    <td><?php echo htmlspecialchars($row['tanggal_main']); ?></td>
                    <td>
                        <strong><?php echo $jam_mulai . ' - ' . $jam_selesai; ?></strong><br>
                        <small>(Durasi: <?php echo $row['durasi_jam']; ?> Jam)</small>
                    </td>
                    <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    <td><span class="status-badge"><?php echo htmlspecialchars($row['status_pesanan']); ?></span></td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; padding:30px;'>Belum ada riwayat booking lapangan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>