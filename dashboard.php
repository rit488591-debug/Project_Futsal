<?php 
require_once 'koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM lapangan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futsal Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">FUTSAL<span>BOOK</span>
        </div>
        <nav>
            <a href="dashboard.php">Home</a>
            <a href="#lapangan">Lapangan</a>
            <a href="riwayat_booking.php">Riwayat Booking</a>
            <a href="logout.php" style="color: #ff4d4d;">Logout</a>
        </nav>
        <a href="#lapangan" class="btn-book">Booking sekarang!</a>
    </header>
    <section class="hero">
        <div class="hero-content">
            <h1>MAIN FUTSAL<br>JADI LEBIH <span>SERU!</span></h1>
            <p>
                Temukan lapangan futsal terbaik. Pesan jadwal bermainmu sekarang! 
            </p>
            <a href="#lapangan" class="btn-book">Lihat Lapangan</a>
        </div>
    </section>
    <section class="lapangan" id="lapangan">
        <h2>PILIH LAPANGANMU!</h2>
        <p class="subtitle">Lapangan terbaik untuk pertandinganmu</p>
        <div class="card-container">
            <?php while($data = mysqli_fetch_assoc($query)) {?>
            <div class="card">
                <img
    src="images/<?php echo htmlspecialchars($data['gambar']); ?>"
    alt="Foto Lapangan"
>
                <div class="card-content">
                    <h3><?php echo     htmlspecialchars($data['nama_lapangan']); ?></h3>
                    <p>Jenis:  
                       <?php echo htmlspecialchars($data['jenis_lapangan']); ?>
                    </p> 
                    <p>Fasilitas:
                       <?php echo htmlspecialchars($data['fasilitas']); ?>
                    </p>
                   <h4>Rp <?php echo number_format($data['harga_per_jam'], 0, ',', '.'); ?> / jam 
                    </h4>
                    <p>
                        <?php echo htmlspecialchars($data['status']); ?>
                    </p>
                    <a href="booking.php?id=<?php echo $data['id']; ?>" class="btn-book" style="display: block; text-align: center; margin-top: 15px;">Pesan Lapangan Ini</a>
                </div>
            </div>
            <?php }?>
        </div>
         
        
    </section>
    <section class="kontak" id="kontak">
        <h2>INGIN BOOKING LAPANGAN?</h2>
        <p>
            Hubungi penanggung jawab kami melalui WhatsApp
        </p>
        <a href="https://wa.me/6212345678" target="_blank" rel="noopener noreferrer" class="btn-wa">
            Hubungi WhatsApp
        </a>
    </section>
    <footer>
        <p>&copy; 2026 FutsalBook. All Rights Reserved.</p>
    </footer>
</body>
</html>