<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['login_admin']) || $_SESSION['login_admin'] !== true) {
    header("Location: ../pages/loginadmin.php");
    exit(); // Menghentikan eksekusi lebih lanjut
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RAFZZ Car - Admin Pages</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="../script.js?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .sidebar a {
            text-decoration: none;
            color: inherit;
            display: block;
            padding: 10px 15px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #f0f0f0;
            color: #333;
        }

        .sidebar .menu-item.active a {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }

        .sidebar .menu-item {
            margin: 5px 0;
            border-radius: 5px;
            overflow: hidden;
        }

        .notification {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            display: none;
        }

        .notification.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div id="notification" class="notification"></div>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">RAFZZ Car</div>

            <!-- <p class="logo">Admin</p> -->

            <div class="menu-item <?php echo $page == 'dashboard' ? 'active' : ''; ?>">
                <a href="index.php?page=dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="menu-item <?php echo $page == 'mobil' ? 'active' : ''; ?>">
                <a href="index.php?page=mobil">
                    <i class="fas fa-car"></i>
                    <span>Mobil</span>
                </a>
            </div>
            <div class="menu-item <?php echo $page == 'sopir' ? 'active' : ''; ?>">
                <a href="index.php?page=sopir">
                    <i class="fas fa-users"></i>
                    <span>Sopir</span>
                </a>
            </div>
            <div class="menu-item <?php echo $page == 'booking' ? 'active' : ''; ?>">
                <a href="index.php?page=booking">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booking</span>
                </a>
            </div>
            <div class="menu-item <?php echo $page == 'pesan' ? 'active' : ''; ?>">
                <a href="index.php?page=pesan">
                    <i class="fas fa-comment"></i>
                    <span>Pesan</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="../pages/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <?php

            switch ($page) {
                case 'dashboard':
                    include '../pages/dashboard.php';
                    break;
                case 'mobil':
                    include '../pages/mobil.php';
                    break;
                case 'sopir':
                    include '../pages/sopir.php';
                    break;
                case 'booking':
                    include '../pages/booking.php';
                    break;
                case 'setting':
                    include '../pages/setting.php';
                    break;
                case 'pesan':
                    include '../pages/pesan.php';
                    break;
                default:
                    include '../pages/dashboard.php';
            }
            ?>
        </div>
    </div>



</body>

</html>