<?php
include '../admin/config/config.php';
session_start();

if (isset($_POST['register'])) {
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Memasukkan data pengguna ke database
    $query = "INSERT INTO user1 (nama_depan, nama_belakang, email, password) VALUES ('$nama_depan', '$nama_belakang', '$email', '$password')";
    if ($conn->query($query)) {
        header("Location: ../Login/login.php");
        exit();
    } else {
        $error_message = "Registrasi gagal. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffz Car - Sign Up</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="left-side"></div>
        <div class="right-side">
            <div class="form-container">
                <h1>Create An Account</h1>
                <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>

                <div class="login-link">
                    Already have an account? <a href="login.php">Log in</a>
                </div>

                <form method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="nama_depan" placeholder="Nama Depan" required />
                        </div>
                        <div class="form-group">
                            <input type="text" name="nama_belakang" placeholder="Nama Belakang" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required />
                    </div>
                    <div class="form-group password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            required />
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" id="terms" required />
                        <label for="terms">I agree to the <span class="highlight">Terms and conditions</span></label>
                    </div>
                    <button type="submit" name="register">Buat Akun</button>
                </form>

                <div class="social-login">
                    <div class="google-btn">
                        <img src="https://www.google.com/favicon.ico" alt="Google" width="20" height="20" />
                        Google
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const passwordToggle = document.querySelector(".password-toggle i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.classList.remove("fa-eye");
                passwordToggle.classList.add("fa-eye-slash"); // Ganti ikon ke mata tertutup
            } else {
                passwordInput.type = "password";
                passwordToggle.classList.remove("fa-eye-slash");
                passwordToggle.classList.add("fa-eye"); // Ganti ikon ke mata terbuka
            }
        }
    </script>
</body>

</html>