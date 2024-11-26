<?php
session_start();

include '../config/config.php';

if (isset($_POST['login_admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM login_admin WHERE username='$username'");
    if ($result->num_rows > 0) {
        $login_admin = $result->fetch_assoc();

        if ($password === $login_admin['password']) {
            $_SESSION['login_admin'] = true;
            $_SESSION['admin_data'] = $login_admin;
            header("Location: ../index/index.php");
            exit();
        } else {
            $error_message = "Password salah.";
        }
    } else {
        $error_message = "Username tidak ditemukan.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Raffz Car</title>
    <link rel="stylesheet" href="../admin.css ?v=<?php echo time(); ?>" />
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