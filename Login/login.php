<?php
session_start();
include '../admin/config/config.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM user1 WHERE email='$email'");
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user1'] = $user;
        header("Location: ../Homepage/homepage.php");
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

                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                <div class="social-login">
                    <div class="google-btn">
                        <img src="https://www.google.com/favicon.ico" alt="Google" width="20" height="20" />
                        Google
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>