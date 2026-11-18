<?php
require_once 'koneksi.php';
$pesan = "";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Username sudah terdaftar, silakan gunakan yang lain!";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        if ($insert) {
            header("Location: login.php?pesan=registrasiberhasil");
            exit;
        } else {
            $pesan = "Pendaftaran gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - FutsalBook</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container { max-width: 400px; margin: 80px auto; background: #16231e; padding: 30px; border-radius: 12px; border: 1px solid #293b32; }
        .auth-group { margin-bottom: 20px; }
        .auth-group label { display: block; margin-bottom: 8px; color: #ddd; font-weight: 600; }
        .auth-group input { width: 100%; padding: 12px; background: #0b1110; border: 1px solid #293b32; border-radius: 6px; color: white; }
        .error-msg { background: #ff4d4d; color: white; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Daftar Akun Baru</h2>
        <p class="subtitle" style="margin-bottom: 20px;">Buat akun untuk mulai booking lapangan</p>
        
        <?php if (!empty($pesan)) { echo "<div class='error-msg'>$pesan</div>"; } ?>

        <form action="" method="POST">
            <div class="auth-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Masukkan username">
            </div>
            <div class="auth-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>
            <button type="submit" name="register" class="btn-book" style="width: 100%; border: none; cursor: pointer;">Daftar Sekarang</button>
        </form>
        <p style="margin-top: 15px; text-align: center; font-size: 13px; color: #aaa;">Sudah punya akun? <a href="login.php" style="color: #b7ff38;">Login di sini</a></p>
    </div>
</body>
</html>