<?php
include '../admin/config/config.php';

$mobil_result = $conn->query("SELECT * FROM mobil");

$current_page = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffz Car - Daftar Mobil</title>
    <link rel="stylesheet" href="daftarmobil.css?v=<?php echo time(); ?>" />
</head>



<body>
    <?php include '../navbar/navbar.php'; ?>

    <section id="hero">
        <div class="container">
            <div class="hero-content">
                <h1>DAFTAR MOBIL</h1>
                <h2>YANG KAMI SEWAKAN</h2>
            </div>
        </div>
    </section>
    <section class="cars-list">
        <h3>Pilih Mobil yang Ingin Disewa!</h3>
        <p>
            Luangkan waktu Anda untuk melihat berbagai pilihan yang kami tawarkan. Setiap mobil telah dirawat dengan
            baik dan siap menemani petualangan Anda. Jadi, silakan pilih mobil yang ingin Anda sewa, dan siapkan diri
            untuk pengalaman berkendara yang menyenangkan!
        </p>
        <div class="cars-container">
            <?php
            while ($mobil = $mobil_result->fetch_assoc()):
                $imagePath = htmlspecialchars('../admin/index/img/' . $mobil['foto_mobil']); ?>

                <div class="car-card">
                    <img src="<?= htmlspecialchars('../admin/index/img/' . $mobil['foto_mobil']) ?>" alt="<?php echo htmlspecialchars($mobil['nama_mobil']); ?>">
                    <h4><?= htmlspecialchars($mobil['nama_mobil']) ?></h4>
                    <p>Rp <?php echo number_format($mobil['harga_per_hari'], 0, ',', '.'); ?></p>
                    <!-- <p><?php echo htmlspecialchars($mobil['tahun_mobil']); ?></p> -->
                    <ul class="car-features">
                        <li><i class="icon"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                    <path d="M0 1h24v22h-24v-22zm22 20v-15h-20v15h20zm-5.455-10.48l-4.143 3.579c-.675-.138-1.401.068-1.894.618-.735.824-.665 2.088.159 2.824.823.736 2.088.665 2.824-.158.492-.551.616-1.296.402-1.951l3.107-4.507-.455-.405zm-9.545 6.48h-3c0-4.415 3.585-8 8-8 1.163 0 2.269.249 3.267.696l-2.79 2.326-.477-.022c-2.759 0-5 2.24-5 5zm13 0h-3c0-.864-.219-1.676-.605-2.385l1.729-2.761c1.17 1.392 1.876 3.187 1.876 5.146z" />
                                </svg></i></li>
                        <li><i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M17.997 18h-11.995l-.002-.623c0-1.259.1-1.986 1.588-2.33 1.684-.389 3.344-.736 2.545-2.209-2.366-4.363-.674-6.838 1.866-6.838 2.491 0 4.226 2.383 1.866 6.839-.775 1.464.826 1.812 2.545 2.209 1.49.344 1.589 1.072 1.589 2.333l-.002.619zm4.811-2.214c-1.29-.298-2.49-.559-1.909-1.657 1.769-3.342.469-5.129-1.4-5.129-1.265 0-2.248.817-2.248 2.324 0 3.903 2.268 1.77 2.246 6.676h4.501l.002-.463c0-.946-.074-1.493-1.192-1.751zm-22.806 2.214h4.501c-.021-4.906 2.246-2.772 2.246-6.676 0-1.507-.983-2.324-2.248-2.324-1.869 0-3.169 1.787-1.399 5.129.581 1.099-.619 1.359-1.909 1.657-1.119.258-1.193.805-1.193 1.751l.002.463z" />
                                </svg></i></li>
                        <li><i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M17 10.645v-2.29c-1.17-.417-1.907-.533-2.28-1.431-.373-.9.07-1.512.6-2.625l-1.618-1.619c-1.105.525-1.723.974-2.626.6-.9-.373-1.017-1.116-1.431-2.28h-2.29c-.412 1.158-.53 1.907-1.431 2.28h-.001c-.9.374-1.51-.07-2.625-.6l-1.617 1.619c.527 1.11.973 1.724.6 2.625-.375.901-1.123 1.019-2.281 1.431v2.289c1.155.412 1.907.531 2.28 1.431.376.908-.081 1.534-.6 2.625l1.618 1.619c1.107-.525 1.724-.974 2.625-.6h.001c.9.373 1.018 1.118 1.431 2.28h2.289c.412-1.158.53-1.905 1.437-2.282h.001c.894-.372 1.501.071 2.619.602l1.618-1.619c-.525-1.107-.974-1.723-.601-2.625.374-.899 1.126-1.019 2.282-1.43zm-8.5 1.689c-1.564 0-2.833-1.269-2.833-2.834s1.269-2.834 2.833-2.834 2.833 1.269 2.833 2.834-1.269 2.834-2.833 2.834z" />
                                </svg></i></li>
                        <li><i class="icon"><svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 6H8C7.05719 6 6.58579 6 6.29289 6.29289C6 6.58579 6 7.05719 6 8C6 8.94281 6 9.41421 6.29289 9.70711C6.58579 10 7.05719 10 8 10H11C11.9428 10 12.4142 10 12.7071 9.70711C13 9.41421 13 8.94281 13 8C13 7.05719 13 6.58579 12.7071 6.29289C12.4142 6 11.9428 6 11 6Z" stroke="#1C274C" stroke-width="1.5" />
                                </svg></i></li>
                    </ul>
                    <a href="../HalamanSewa/sewa.php?nama_mobil=<?= urlencode($mobil['nama_mobil']) ?>&harga_per_hari=<?= urlencode($mobil['harga_per_hari']) ?>&foto_mobil=<?= urlencode($mobil['foto_mobil']) ?>" class="rent-btn">Sewa Sekarang</a>

                </div>
            <?php endwhile ?>
        </div>
    </section>

    <section class="faq">
        <h3>FAQ</h3>
        <div class="faq-content">
            <div class="faq-text">
                <p>Selamat datang di bagian FAQ kami! Kami paham bahwa Anda mungkin memiliki banyak pertanyaan sebelum
                    memutuskan untuk menyewa mobil. Oleh karena itu, kami telah mengumpulkan pertanyaan-pertanyaan yang
                    sering diajukan beserta jawabannya untuk membantu Anda. Jika Anda tidak menemukan jawaban yang Anda
                    cari, jangan ragu untuk menghubungi tim customer service kami. Kami siap membantu Anda dengan senang
                    hati!</p>
            </div>
            <div class="faq-questions">
                <h4>Apa syarat untuk menyewa mobil?</h4>
                <p>Untuk menyewa mobil, Anda hanya perlu menunjukkan KTP dan SIM yang valid. Pastikan usia Anda minimal
                    21 tahun.</p>

                <h4>Apakah mobil dilengkapi dengan asuransi?</h4>
                <p>Tentu saja! Setiap mobil sewaan sudah termasuk asuransi dasar untuk melindungi Anda dan mobil selama
                    masa sewa.</p>

                <h4>Bagaimana jika saya mengembalikan mobil terlambat?</h4>
                <p>Kami memahami bahwa terkadang ada halangan. Namun, ada biaya tambahan untuk setiap jam keterlambatan.
                </p>

                <h4>Apakah bisa sewa mobil tanpa sopir?</h4>
                <p>Ya, kami menawarkan opsi sewa mobil tanpa sopir, namun ada syarat tambahan yang harus dipenuhi.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="../Asset/logo.png" alt="RAFFZ Car Logo">
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4>Homepage</h4>
                    <a href="#">Advertisement</a>
                    <a href="#">Car</a>
                    <a href="#">Helpdesk</a>
                </div>
                <div class="footer-column">
                    <h4>Contact</h4>
                    <a href="#">Booking</a>
                    <a href="#">FAQ</a>
                    <a href="#">Contact Us</a>
                </div>
                <div class="footer-column">
                    <h4>Footer</h4>
                    <a href="#">Terms of Service</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">About Us</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="copyright">
                © 2024 RAFFZ Car. All rights reserved.
            </div>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>
</body>

</html>