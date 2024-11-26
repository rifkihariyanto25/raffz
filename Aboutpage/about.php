<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffz Car</title>
    <link rel="stylesheet" href="about.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- Header remains the same -->
    <!-- <header>
        <nav>
            <div class="logo">
                <img src="../Asset/logo.png" alt="Raffz Car Logo">
            </div>
            <ul>
                <li><a href="../Homepage/homepage.php">Home</a></li>
                <li><a href="../Listmobil/daftarmobil.php">Daftar Mobil</a></li>
                <li><a href="../Aboutpage/about.html">About</a></li>
                <li><a href="../Kontak/Kontak.php">Contact</a></li>
            </ul>
            <div class="user-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm7.753 18.305c-.261-.586-.789-.991-1.871-1.241-2.293-.529-4.428-.993-3.393-2.945 3.145-5.942.833-9.119-2.489-9.119-3.388 0-5.644 3.299-2.489 9.119 1.066 1.964-1.148 2.427-3.393 2.945-1.084.25-1.608.658-1.867 1.246-1.405-1.723-2.251-3.919-2.251-6.31 0-5.514 4.486-10 10-10s10 4.486 10 10c0 2.389-.845 4.583-2.247 6.305z" />
                </svg>
            </div>
        </nav>
    </header> -->
    <?php include '../navbar/navbar.php'; ?>

    <!-- Car Gallery Section remains the same -->
    <section class="car-gallery">
        <h1 class="gallery-title">RAFFZ CAR</h1>
        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="../Asset/4.png" alt="Car Service">
            </div>
            <div class="gallery-item">
                <img src="../Asset/3.png" alt="Car Fleet">
            </div>
            <div class="gallery-item">
                <img src="../Asset/2.png" alt="Car Lineup">
            </div>
            <div class="gallery-item">
                <img src="../Asset/1.png" alt="Car Service Staff">
            </div>
        </div>
    </section>

    <!-- Updated Team Section for 5 members -->
    <section class="team-section">
        <h2 class="team-title">Tim Kami</h2>
        <div class="team-grid">
            <div class="team-member">
                <div class="member-image">
                    <img src="../Asset/Ripks.png" alt="Team Member 3">
                </div>
                <div class="member-info">
                    <h3>Rifki Aditya Hariyanto</h3>
                    <p>Project Manajer</p>
                </div>
            </div>
            <div class="team-member">
                <div class="member-image">
                    <img src="../Asset/akbara.png" alt="Team Member 1">
                </div>
                <div class="member-info">
                    <h3>Raihan Akbar Rabbani</h3>
                    <p>Software tester</p>
                </div>
            </div>
            <div class="team-member">
                <div class="member-image">
                    <img src="../Asset/gwehj.png" alt="Team Member 2">
                </div>
                <div class="member-info">
                    <h3>Muhammad Fikri Fauzi</h3>
                    <p>Front End Developer</p>
                </div>
            </div>

        </div>
        <div class="team-bottom-row">
            <div class="team-member">
                <div class="member-image">
                    <img src="../Asset/pendol.png" alt="Team Member 4">
                </div>
                <div class="member-info">
                    <h3>Fendi Nur Maulam</h3>
                    <p>Back End Developer</p>
                </div>
            </div>
            <div class="team-member">
                <div class="member-image">
                    <img src="../Asset/jaktod.png" alt="Team Member 5">
                </div>
                <div class="member-info">
                    <h3>Muhamad Dimas Nurzaky</h3>
                    <p>Designer UI UX</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section and Footer remain the same -->
    <section class="faq-section">
        <h2 class="faq-title">FAQ</h2>
        <div class="faq-grid">
            <div class="faq-item">
                <h3>Apa syarat untuk menyewa mobil?</h3>
                <p>Untuk menyewa mobil, Anda memerlukan KTP yang masih berlaku, SIM A, dan jaminan tambahan berupa motor
                    atau uang tunai.</p>
            </div>
            <div class="faq-item">
                <h3>Apakah bisa rental mobil tanpa driver?</h3>
                <p>Ya, kami menyediakan layanan rental mobil dengan atau tanpa driver sesuai dengan kebutuhan Anda.</p>
            </div>
            <div class="faq-item">
                <h3>Bagaimana cara mengajukan pengaduan?</h3>
                <p>Anda dapat menghubungi customer service kami melalui WhatsApp atau email yang tercantum di halaman
                    kontak.</p>
            </div>
            <div class="faq-item">
                <h3>Apakah bisa sewa mobil untuk keluar kota?</h3>
                <p>Ya, kami menyediakan layanan rental mobil untuk perjalanan keluar kota dengan syarat dan ketentuan
                    tertentu.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Tentang Kami</h3>
                <ul>
                    <li><a href="#">Profil</a></li>
                    <li><a href="#">Layanan</a></li>
                    <li><a href="#">Tim</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Layanan</h3>
                <ul>
                    <li><a href="#">Rental Mobil</a></li>
                    <li><a href="#">Dengan Supir</a></li>
                    <li><a href="#">Tanpa Supir</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kontak</h3>
                <ul>
                    <li><a href="#">WhatsApp</a></li>
                    <li><a href="#">Email</a></li>
                    <li><a href="#">Lokasi</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Social Media</h3>
                <ul>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>