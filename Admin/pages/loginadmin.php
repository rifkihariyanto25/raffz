<?php
session_start();

include '../config/config.php';

if (isset($_POST['login_admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data admin berdasarkan username
    $result = $conn->query("SELECT * FROM login_admin WHERE username='$username'");
    $login_admin = $result->fetch_assoc();

    // Validasi username dan password
    if ($login_admin && $password == $login_admin['password']) { // Langsung mencocokkan password
        $_SESSION['login_admin'] = $login_admin;
        // Redirect ke halaman index.php
        header("Location: ../index/index.php");
        exit();
    } else {
        // Tampilkan pesan kesalahan jika login gagal
        $error_message = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Raffz Car</title>
    <link rel="stylesheet" href="../../loginadmin/style.css ?v=<?php echo time(); ?>" />
</head>

<body>
    <div class="login-container">
        <div class="right">
            <h2>Welcome Back!</h2>
            <form id="login-form" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <button type="submit" name="login_admin">Masuk</button>
            </form>
            <?php if (isset($error_message)) : ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>