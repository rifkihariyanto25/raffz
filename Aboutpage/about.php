<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffz Car</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php include '../navbar/navbar.php'; ?>

    <!-- Car Gallery Section remains the same -->
    <section class="car-gallery">
        <!-- <h1 class="gallery-title">RAFFZ CAR</h1> -->
        <div class="gallery-grid">
            <h1 class="gallery-text1">RAFFZ CAR</h1>
            <p class="gallery-text2"> Melayani dengan Sepenuh Hati</p>
            <div class="gallery-item1">
                <img src="../Asset/4.png" alt="Car Service">
            </div>
            <div class="gallery-item2">
                <img src="../Asset/3.png" alt="Car Fleet">
            </div>
            <div class="gallery-item3">
                <img src="../Asset/2.png" alt="Car Lineup">
            </div>
            <div class="gallery-item4">
                <img src="../Asset/1.png" alt="Car Service Staff">
            </div>
        </div>
    </section>

    <!-- Updated Team Section for 5 members -->
    <section class="team-section">
        <div class="team-container">
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