<?php
require_once 'koneksi.php';

// Ambil ID lapangan dari URL
$id_lapangan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data lapangan berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM lapangan WHERE id = $id_lapangan");
$lapangan = mysqli_fetch_assoc($query);

// Jika lapangan tidak ditemukan, kembalikan ke dashboard
if (!$lapangan) {
    header("Location: dashboard.php");
    exit;
}

$pesan_sukses = "";

// Jika form dikirim
if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pemesan']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $tanggal = $_POST['tanggal_main'];
    $jam = $_POST['jam_mulai'];
    $durasi = intval($_POST['durasi_jam']);
    
    // Hitung total harga otomatis
    $total_harga = $durasi * $lapangan['harga_per_jam'];

    // Simpan ke database
    $insert = mysqli_query($conn, "INSERT INTO booking (id_lapangan, nama_pemesan, no_hp, tanggal_main, jam_mulai, durasi_jam, total_harga) 
                                   VALUES ('$id_lapangan', '$nama', '$no_hp', '$tanggal', '$jam', '$durasi', '$total_harga')");
    
    if ($insert) {
        $pesan_sukses = "Booking berhasil! Total tagihan Anda adalah Rp " . number_format($total_harga, 0, ',', '.') . ". Silakan lakukan konfirmasi ke admin.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking - <?php echo htmlspecialchars($lapangan['nama_lapangan']); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: #16231e;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #293b32;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #ddd;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            background: #0b1110;
            border: 1px solid #293b32;
            border-radius: 6px;
            color: white;
            font-family: 'Montserrat', sans-serif;
        }
        .alert-success {
            background: #25d366;
            color: white;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">FUTSAL<span>BOOK</span></div>
        <nav>
            <a href="dashboard.php">Home</a>
        </nav>
    </header>

    <div class="form-container">
        <h2>Form Pemesanan: <?php echo htmlspecialchars($lapangan['nama_lapangan']); ?></h2>
        <p class="subtitle" style="margin-bottom: 25px;">Tarif: Rp <?php echo number_format($lapangan['harga_per_jam'], 0, ',', '.'); ?> / jam</p>

        <?php if (!empty($pesan_sukses)) { ?>
            <div class="alert-success"><?php echo $pesan_sukses; ?></div>
            <a href="dashboard.php" class="btn-book" style="text-align:center; display:block;">Kembali ke Beranda</a>
        <?php } else { ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Nama Pemesan / Tim</label>
                <input type="text" name="nama_pemesan" required placeholder="Masukkan nama Anda">
            </div>
            <div class="form-group">
                <label>Nomor WhatsApp</label>
                <input type="text" name="no_hp" required placeholder="Contoh: 081234567890">
            </div>
            <div class="form-group">
                <label>Tanggal Main</label>
                <input type="date" name="tanggal_main" required>
            </div>
            <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="jam_mulai" required>
            </div>
            <div class="form-group">
                <label>Durasi (Jam)</label>
                <select name="durasi_jam">
                    <option value="1">1 Jam</option>
                    <option value="2">2 Jam</option>
                    <option value="3">3 Jam</option>
                    <option value="4">4 Jam</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn-book" style="width: 100%; border: none; cursor: pointer;">Konfirmasi Pesanan</button>
        </form>
        <?php } ?>
    </div>
</body>
</html>