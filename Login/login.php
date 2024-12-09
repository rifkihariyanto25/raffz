<?php

date_default_timezone_set('Asia/Jakarta');
session_start();
include '../admin/config/config.php';

if (isset($_POST['login'])) {
    // Ambil input dari form
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Cek di database
    $result = $conn->query("SELECT * FROM user1 WHERE email='$email'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan informasi pengguna ke sesi
        $_SESSION['user1'] = $user;

        // Redirect ke halaman sebelumnya atau homepage
        $redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : '../Homepage/homepage.php';
        header("Location: ../HalamanSewa/sewa.php");
        exit();
    } else {
        $error_message = "Email atau password salah.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Mobil</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="container">
        <!-- <div class="left-side">
            <a href="../Asset/Rental banner.png"></a>
        </div> -->
        <div class="right-side">
            <div class="form-container">
                <h1>Login Pengguna</h1>
                <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

                <form method="post">
                    <div class="form-group">
                        <input type="email" name="email" required placeholder="Email">
                    </div>
                    <div class="form-group password-container">
                        <input type="password" name="password" required placeholder="Enter your password">
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" id="terms" />
                        <label for="terms">I agree to the <span class="highlight">Terms and conditions</span></label>
                    </div>
                    <button type="submit" name="login">Login</button>
                </form>

                <p>Belum punya akun? <a href="../SignUp/Register.php">Daftar di sini</a></p>

            </div>
        </div>
    </div>

</body>

</html>