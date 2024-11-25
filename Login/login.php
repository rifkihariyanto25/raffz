<?php

date_default_timezone_set('Asia/Jakarta');
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


// panggil library
require_once 'vendor/autoload.php';

use Google\Service\Oauth2;
use Google\Client;

$client_id = '273853361585-8s9r9s5hr0fa2c4b8qrbqiipcr0ecbeb.apps.googleusercontent.com';
$client_secret = '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';
$redirect__uri = 'http://localhost/trial/Login/login.php';


// inisiasi google 
try {
    $client = new Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect__uri);

    // Tambahan konfigurasi
    $client->setAccessType('offline');
    $client->setPrompt('select_account');
    $client->setIncludeGrantedScopes(true);

    $client->addScope('email');
    $client->addScope('profile');

    // Generate auth URL
    $auth_url = $client->createAuthUrl();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

// insert db google sql
if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (!isset($token['error'])) {
            $client->setAccessToken($token['access_token']);

            // inisiasi google oauth
            $service = new Oauth2($client);
            $profile = $service->userinfo->get();

            // tampung data dari akun google
            $g_name = mysqli_real_escape_string($conn, $profile->name);
            $g_email = mysqli_real_escape_string($conn, $profile->email);
            $g_id = mysqli_real_escape_string($conn, $profile->id);
            $currtime = date('Y-m-d H:i:s');

            // Check existing user
            $query_check = "SELECT * FROM db_login_google WHERE oauth_id = '$g_id'";
            $run_query_check = mysqli_query($conn, $query_check);

            if (!$run_query_check) {
                throw new Exception("Database error: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($run_query_check) > 0) {
                // Update existing user
                $query_update = "UPDATE db_login_google SET 
                    fullname = '$g_name', 
                    email = '$g_email', 
                    last_login = '$currtime' 
                    WHERE oauth_id = '$g_id'";

                if (!mysqli_query($conn, $query_update)) {
                    throw new Exception("Update failed: " . mysqli_error($conn));
                }
            } else {
                // Insert new user
                $query_insert = "INSERT INTO db_login_google (fullname, email, oauth_id, last_login) 
                    VALUES ('$g_name', '$g_email', '$g_id', '$currtime')";

                if (!mysqli_query($conn, $query_insert)) {
                    throw new Exception("Insert failed: " . mysqli_error($conn));
                }
            }

            // Set session variables
            session_start();
            $_SESSION['user_email'] = $g_email;
            $_SESSION['user_name'] = $g_name;
            $_SESSION['logged_in'] = true;

            echo "Login Berhasil";
            // Redirect ke halaman dashboard atau home
            header("Location: ../Homepage/homepage.php");
            exit();
        } else {
            throw new Exception("Token error: " . $token['error']);
        }
    } catch (Exception $e) {
        echo "Login Gagal: " . $e->getMessage();
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
                <div class="social-login">
                    <a href="<?php echo $auth_url; ?>">
                        <img src="../Asset/web_light_sq_SU@1x.png" alt="button google">
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>