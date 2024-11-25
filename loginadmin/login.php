<?php
session_start();

include '../admin/config/config.php';

if (isset($_POST['login_admin'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = $conn->query("SELECT * FROM login_admin WHERE username='$username'");
  $login_admin = $result->fetch_assoc();
  if ($login_admin && password_verify($password, $login_admin['password'])) {
    $_SESSION['login_admin'] = $login_admin;
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Raffz Car</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
</head>

<body>
  <div class="login-container">
    <!-- <div class="left">
      <h1>Raffz Car</h1>
      <p>Melayani Dengan Sepenuh Hati</p>
      <img src="/Asset/poster-login.png" alt="Car Image" class="car-image" />
    </div> -->
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
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>