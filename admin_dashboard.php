<?php
session_start();
require_once 'koneksi.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin_login.php");
    exit;
}

// Hapus data booking jika tombol hapus diklik
if (isset($_GET['hapus'])) {
    $id_booking = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM booking WHERE id_booking = $id_booking");
    header("Location: admin_dashboard.php");
    exit;
}

// Ambil semua data booking dari database beserta nama lapangannya
$query = mysqli_query($conn, "SELECT booking.*, lapangan.nama_lapangan, lapangan.jenis_lapangan 
                              FROM booking 
                              JOIN lapangan ON booking.id_lapangan = lapangan.id 
                              ORDER BY booking.tanggal_main ASC, booking.jam_mulai ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - FutsalBook</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .table-admin { width: 100%; border-collapse: collapse; background: #16231e; border-radius: 8px; overflow: hidden; border: 1px solid #293b32; }
        .table-admin th, .table-admin td { padding: 14px; text-align: left; border-bottom: 1px solid #293b32; font-size: 13px; color: #ccc; }
        .table-admin th { background: #101a17; color: #b7ff38; font-weight: 700; }
        .btn-hapus { background: #ff4d4d; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 11px; font-weight: 600; }
        .btn-hapus:hover { background: #cc0000; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .timer-badge { background: #101a17; border: 1px solid #b7ff38; color: #b7ff38; padding: 6px 10px; border-radius: 4px; font-family: monospace; font-size: 12px; font-weight: bold; display: inline-block; }
        .timer-expired { border-color: #ff4d4d; color: #ff4d4d; }
    </style>
</head>
<body>
    <header>
        <div class="logo">FUTSAL<span>BOOK</span> <span style="font-size: 12px; background: #b7ff38; color: #101a17; padding: 2px 6px; border-radius: 4px;">ADMIN</span></div>
        <nav>
            <a href="admin_dashboard.php">Kelola Pesanan</a>
            <a href="logout.php" style="color: #ff4d4d;">Logout Admin</a>
        </nav>
    </header>

    <div class="admin-container">
        <div class="top-bar">
            <div>
                <h2>Dashboard Pengelola Lapangan</h2>
                <p class="subtitle" style="margin: 5px 0 0 0;">Pantau jadwal, rentang waktu main, dan timer menuju pertandingan</p>
            </div>
        </div>

        <table class="table-admin">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lapangan</th>
                    <th>Nama Pemesan / HP</th>
                    <th>Jadwal & Waktu Main</th>
                    <th>Sisa Waktu (Timer)</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($query) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) {
                        // Gabungkan tanggal dan jam main untuk target timer JavaScript
                        $target_datetime = $row['tanggal_main'] . ' ' . $row['jam_mulai'];

                        // Menghitung jam selesai berdasarkan jam mulai + durasi jam
                        $jam_mulai = date('H:i', strtotime($row['jam_mulai']));
                        $jam_selesai = date('H:i', strtotime($row['jam_mulai'] . ' + ' . $row['durasi_jam'] . ' hours'));
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><strong><?php echo htmlspecialchars($row['nama_lapangan']); ?></strong><br><small><?php echo htmlspecialchars($row['jenis_lapangan']); ?></small></td>
                    <td><?php echo htmlspecialchars($row['nama_pemesan']); ?><br><small><?php echo htmlspecialchars($row['no_hp']); ?></small></td>
                    <td>
                        <?php echo htmlspecialchars($row['tanggal_main']); ?><br>
                        <strong><?php echo $jam_mulai . ' - ' . $jam_selesai; ?></strong> 
                        <small>(<?php echo $row['durasi_jam']; ?> Jam)</small>
                    </td>
                    <td>
                        <!-- Elemen Timer Countdown -->
                        <span class="timer-badge" id="timer-<?php echo $row['id_booking']; ?>" data-time="<?php echo $target_datetime; ?>">
                            Menghitung...
                        </span>
                    </td>
                    <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="admin_dashboard.php?hapus=<?php echo $row['id_booking']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data booking ini?')">Hapus</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center; padding:30px;'>Belum ada data pesanan masuk.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Skrip JavaScript untuk menjalankan Timer secara Real-time -->
    <script>
        function updateTimers() {
            const timers = document.querySelectorAll('.timer-badge');
            
            timers.forEach(timer => {
                const targetTime = new Date(timer.getAttribute('data-time')).getTime();
                const now = new Date().getTime();
                const distance = targetTime - now;

                if (distance < 0) {
                    timer.innerHTML = "Waktu Main Telah Lewat";
                    timer.classList.add('timer-expired');
                } else {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    let text = "";
                    if (days > 0) text += days + "hari ";
                    text += String(hours).padStart(2, '0') + ":" + 
                            String(minutes).padStart(2, '0') + ":" + 
                            String(seconds).padStart(2, '0');

                    timer.innerHTML = text;
                }
            });
        }

        // Jalankan setiap 1 detik
        setInterval(updateTimers, 1000);
        updateTimers();
    </script>
</body>
</html>