<?php
session_start();
$pesan = "";

// Login sederhana admin (Username: admin, Password: admin123)
if (isset($_POST['login_admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_login'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $pesan = "Username atau Password Admin salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - FutsalBook</title>
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
        <h2>Login Admin</h2>
        <p class="subtitle" style="margin-bottom: 20px;">Kelola jadwal dan pesanan lapangan</p>
        
        <?php if (!empty($pesan)) { echo "<div class='error-msg'>$pesan</div>"; } ?>

        <form action="" method="POST">
            <div class="auth-group">
                <label>Username Admin</label>
                <input type="text" name="username" required placeholder="Masukkan username">
            </div>
            <div class="auth-group">
                <label>Password Admin</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>
            <button type="submit" name="login_admin" class="btn-book" style="width: 100%; border: none; cursor: pointer;">Masuk Admin</button>
        </form>
        <p style="margin-top: 15px; text-align: center; font-size: 13px; color: #aaa;"><a href="dashboard.php" style="color: #b7ff38;">Kembali ke Beranda Utama</a></p>
    </div>
</body>
</html>