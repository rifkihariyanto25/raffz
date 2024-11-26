<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Example</title>
    <!-- <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <style>
        /* Gaya untuk header */
        header {
            padding: 20px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            /* background-color: white; */
            /* Warna dasar untuk header */
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
        }



        /* Gaya untuk navigasi */
        nav {
            background-color: white;
            border-radius: 50px;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo img {
            height: 40px;
            margin-right: 12px;
        }

        /* Menu list */
        nav ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin: 0 15px;
        }

        /* Link default */
        nav ul li a {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            display: inline-block;
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 5px;
        }

        /* Hover efek */
        nav ul li a:hover {
            background-color: #f0f0f0;
            color: #007BFF;
        }

        /* Gaya untuk menu aktif */
        nav ul li.active a {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }

        /* Ikon pengguna */
        .user-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f0f0f0;
        }

        .user-icon i {
            color: #007BFF;
            font-size: 16px;
        }

        /* Improved Modal Popup Styling */
        .form-popup {

            display: none;
            position: fixed;
            bottom: 50px;
            right: 15px;
            transform: translate(-50%, -50%);
            width: 250px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            background-color: white;
            overflow: hidden;
            transition: all 0.3s ease;
        }


        .popup-header {
            background-color: #002855;
            padding: 20px;
            text-align: center;
            height: 100px;
        }

        .profile-pic {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #d9d9d9;
            text-align: center;
            width: 80px;
            height: 80px;
            line-height: 80px;
            font-size: 40px;
        }

        .user-modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #999;
            cursor: pointer;
            font-size: 24px;
            transition: color 0.3s ease;
        }

        .user-modal-close:hover {
            color: #333;
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            background-color: #f0f0f0;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            font-size: 50px;
            color: #555;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .user-info h2 {
            margin: 0;
            color: #333;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .popup-body {
            text-align: center;
            padding: 20px;
        }

        .name {
            font-size: 18px;
            font-weight: bold;
            color: #333333;
        }

        .email {
            font-size: 14px;
            color: #888888;
            margin-top: 5px;
        }

        .popup-actions {
            display: flex;
            flex-direction: column;
            padding: 10px 20px;
        }

        .action-button {
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            background-color: #f5f5f5;
            color: #333333;
            transition: background-color 0.3s ease;
        }

        .action-button .icon {
            margin-right: 10px;
        }

        .action-button:hover {
            background-color: #eaeaea;
        }

        .action-button.logout {
            background-color: #ffe5e5;
            color: #d9534f;
        }

        .action-button.logout:hover {
            background-color: #ffd5d5;
        }

        .profile-pic-container {
            position: absolute;
            bottom: 190px;
            /* top: 500px; */
            /* Posisi gambar tepat di bawah header */
            left: 50%;
            transform: translateX(-50%);
        }

        .profile-pic {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #ffffff;
            background-color: #d9d9d9;
        }

        .no-underline {
            text-decoration: none;
            /* Hilangkan garis bawah */
            color: inherit;
            /* Warna mengikuti warna teks tombol */
        }

        /* Pastikan link tidak terpisah dari tombol */
        .action-button a {
            display: inline-block;
            /* Buat elemen inline tetap dalam tombol */
        }
    </style>

    <style>
        .welcome-popup {
            position: fixed;
            bottom: 150px;
            right: 150px;
            display: none;
            width: 320px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        .welcome-title {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        .welcome-message {
            font-size: 14px;
            color: #808080;
            margin: 0 0 20px;
        }

        .ilustrasi-pic-container {
            margin-top: -40px;
        }

        .ilustrasi-pic {
            font-size: 50px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #ffffff;
            background-color: #d9d9d9;
        }

        .nologin-button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .nologin-button span {
            font-size: 16px;
        }

        .nologin-button:first-child {
            background-color: #ff6b00;
            color: #ffffff;
        }

        .nologin-button.outline {
            background-color: transparent;
            color: #ff6b00;
            border: 2px solid #ff6b00;
        }

        .nologin-button:hover {
            opacity: 0.9;
        }
    </style>
</head>


<header>
    <nav>
        <div class="logo">
            <img src="../Asset/logo.png" alt="Raffz Car Logo">
        </div>
        <ul>
            <li class="<?php echo $current_page == 'homepage.php' ? 'active' : ''; ?>">
                <a href="../Homepage/homepage.php">Home</a>
            </li>
            <li class="<?php echo $current_page == 'daftarmobildb.php' ? 'active' : ''; ?>">
                <a href="../Listmobil/daftarmobildb.php">Daftar Mobil</a>
            </li>
            <li class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">
                <a href="../Aboutpage/about.php">About</a>
            </li>
            <li class="<?php echo $current_page == 'Kontak.php' ? 'active' : ''; ?>">
                <a href="../Kontak/Kontak.php">Contact</a>
            </li>
        </ul>
        <button class="user-icon" onclick="openForm()">
            <i class="fas fa-user"></i>
        </button>

        <div class="form-popup" id="myForm">
            <div class="form-container">
                <div class="popup-header">
                    <span class="user-modal-close" onclick="closeUserModal()">&times;</span>
                </div>
                <div class="profile-pic-container">
                    <i class="profile-pic fas fa-user"></i>
                </div>
                <div class="popup-body">
                    <h3 class="name">Ridwan Fufufafa</h3>
                    <p class="email">chilipari@gmail.com</p>
                </div>

                <div class="popup-actions">
                    <button class="action-button">
                        <span class="icon">&#8634;</span> <a href="../StatusPemesananRiwayat/index.php" class="no-underline">Riwayat Pesanan</a>
                    </button>
                    <button class="action-button logout">
                        <span class="fas fa-sign-out-alt"></span> Keluar
                    </button>
                </div>
            </div>
        </div>

        <div class="welcome-popup" id="myForm">
            <div class="popup-header">
                <span class="user-modal-close" onclick="closeUserModal()">&times;</span>
            </div>

            <div class="ilustrasi-pic-container">
                <i class="ilustrasi-pic fas fa-user"></i>
            </div>

            <div class="popup-body">
                <h2 class="welcome-title">Selamat Datang</h2>
                <p class="welcome-message">
                    Silahkan masuk atau daftar untuk mengakses profil dan pesanan anda
                </p>
            </div>

            <div class="popup-actions">
                <button class="nologin-button">
                    <span class="fas fa-sign-in-alt"></span>Masuk
                </button>
                <button class="nologin-button outline">
                    <span class="fas fa-user-plus"></span> Daftar Akun
                </button>
            </div>
        </div>
</header>

<script>
    function checkLoginStatus() {

        const isLoggedIn = false;

        const formPopup = document.querySelector('.form-popup');
        const welcomePopup = document.querySelector('.welcome-popup');

        if (isLoggedIn) {
            formPopup.style.display = 'block';
            welcomePopup.style.display = 'none';
        } else {
            formPopup.style.display = 'none';
            welcomePopup.style.display = 'block';
        }
    }

    function openForm() {
        checkLoginStatus();
    }

    function closeUserModal() {
        const formPopup = document.querySelector('.form-popup');
        const welcomePopup = document.querySelector('.welcome-popup');

        formPopup.style.display = 'none';
        welcomePopup.style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const loginButton = document.querySelector('.nologin-button');
        const registerButton = document.querySelector('.nologin-button.outline');

        if (loginButton) {
            loginButton.addEventListener('click', function() {
                window.location.href = '../Login/login.php';
            });
        }

        if (registerButton) {
            registerButton.addEventListener('click', function() {
                window.location.href = '../Register/register.php';
            });
        }

        const logoutButton = document.querySelector('.action-button.logout');
        if (logoutButton) {
            logoutButton.addEventListener('click', function() {
                // Lakukan proses logout
                window.location.href = '../Login/logout.php';
            });
        }
    });

    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
</script>

</html>