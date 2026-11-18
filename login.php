<?php
session_start();
require_once 'koneksi.php';
$pesan = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
            exit;
        }
    }
    $pesan = "Username atau Password salah!";
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - FutsalBook</title>
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
        <h2>Login FutsalBook</h2>
        <p class="subtitle" style="margin-bottom: 20px;">Masuk untuk melanjutkan booking</p>
        
        <?php if (!empty($pesan)) { echo "<div class='error-msg'>$pesan</div>"; } ?>
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'registrasiberhasil') { echo "<div style='background:#25d366; color:white; padding:10px; border-radius:6px; margin-bottom:15px; font-size:13px;'>Registrasi berhasil! Silakan login.</div>"; } ?>

        <form action="" method="POST">
            <div class="auth-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Username Anda">
            </div>
            <div class="auth-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Password Anda">
            </div>
            <button type="submit" name="login" class="btn-book" style="width: 100%; border: none; cursor: pointer;">Login</button>
        </form>
        <p style="margin-top: 15px; text-align: center; font-size: 13px; color: #aaa;">Belum punya akun? <a href="register.php" style="color: #b7ff38;">Daftar di sini</a></p>
    </div>
</body>
</html>