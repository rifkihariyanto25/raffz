<?php
require_once __DIR__ . '/admin/config/config.php';

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffz Car - Homepage</title>
    <link rel="stylesheet" href="Homepage/homepage.css?v=<?php echo time(); ?>" />
</head>

<body>
    <!-- Loading Screen -->
    <div class="loader_bg">
        <div class="loader"></div>
    </div>

    <?php include 'navbar/navbar.php'; ?>

    <section id="hero">
        <div class="container">
            <div class="hero-content">
                <h1>SEWA <span style="color: #FE7844;">MOBIL?</span></h1>
                <p>NYAMAN, CEPAT &</p>
                <p>DOMPET TETAP SELAMAT</p>
            </div>
            <img src="Asset/Ngengeng.png" alt="Car">
        </div>
    </section>

    <section id="features">
        <h2>MENGAPA PILIH KAMI</h2>
        <p style="text-align: center">Ketika Anda mencari layanan sewa mobil, kami tahu bahwa Anda menginginkan
            kenyamanan, keamanan, dan fleksibilitas. Dengan armada kendaraan terbaru, layanan pelanggan yang responsif,
            serta harga yang kompetitif, kami memastikan setiap perjalanan Anda menjadi lebih mudah dan nyaman. Kami
            bangga menjadi mitra perjalanan yang Anda percayai, siap melayani kapan pun dan di mana pun Anda butuhkan.
        </p>
        <div class="feature-grid">
            <div class="feature-card">
                <img src="Asset/image (3).png" alt="Konsultasi">
                <h3>Konsultasi Pemesanan</h3>
                <p>Kami siap membantu Anda menemukan mobil yang tepat untuk kebutuhan Anda.</p>
            </div>
            <div class="feature-card">
                <img src="Asset/image (4).png" alt="Asuransi">
                <h3>Bersiap Sama dengan Asuransi</h3>
                <p>Semua mobil kami dilengkapi dengan asuransi untuk keamanan dan kenyamanan Anda.</p>
            </div>
            <div class="feature-card">
                <img src="Asset/image (5).png" alt="Mobil Terawat">
                <h3>Mobil Terawat dan Teruji</h3>
                <p>Kami menjamin semua mobil dalam kondisi prima dan siap untuk perjalanan Anda.</p>
            </div>
        </div>
    </section>

    <section class="rekomendasi-mobil">
        <h2>REKOMENDASI MOBIL</h2>
        <p>Butuh kendaraan nyaman? Berikut Rekomendasi Mobil Terbaik Yang Kami Sewakan</p>
        <div class="car-grid">
            <div class="car-card">
                <h3>Toyota Avanza</h3>
                <div class="year">2014</div>
                <img src="Asset/avanza.png" alt="Toyota Avanza">
                <div class="price">Rp 299.000</div>
                <button type="button" class="rent-btn" onclick="checkRegistration(event)">Sewa</button>
            </div>
            <div class="car-card">
                <h3>Mitsubishi Xpander</h3>
                <div class="year">2025</div>
                <img src="Asset/xpander.png" alt="Mitsubishi Xpander">
                <div class="price">Rp 399.000</div>
                <button class="rent-btn" onclick="checkRegistration()">Sewa</button>
            </div>
            <div class="car-card">
                <h3>Daihatsu Sigra</h3>
                <div class="year">2019</div>
                <img src="Asset/sigra.png" alt="Daihatsu Sigra">
                <div class="price">Rp 259.000</div>
                <button class="rent-btn" onclick="checkRegistration()">Sewa</button>
            </div>
            <div class="car-card">
                <h3>Honda Brio</h3>
                <div class="year">2020</div>
                <img src="Asset/Brio.png" alt="Honda Brio">
                <div class="price">Rp 259.000</div>
                <button class="rent-btn" onclick="checkRegistration()">Sewa</button>
            </div>
            <div class="car-card">
                <h3>Suzuki Ertiga</h3>
                <div class="year">2021</div>
                <img src="Asset/Erlima.png" alt="Suzuki Ertiga">
                <div class="price">Rp 259.000</div>
                <button class="rent-btn" onclick="checkRegistration()">Sewa</button>
            </div>
            <div class="car-card">
                <h3>Toyota Alphard</h3>
                <div class="year">2022</div>
                <img src="Asset/alphard.png" alt="Toyota Alphard">
                <div class="price">Rp 799.000</div>
                <button class="rent-btn" onclick="checkRegistration()">Sewa</button>
            </div>
            <!-- Repeat similar structure for other car cards -->
        </div>
    </section>
    <section id="testimonials">
        <h2>TESTIMONI</h2>
        <p>Butuh kendaraan nyaman? Berikut Rekomendasi Mobil Terbaik Yang Kami Sewakan</p>
        <div class="testimonial-grid">
            <div class="testimonial-card">
                <img src="Asset/karina.png" alt="Dimas Fauzi Maulana">
                <h3>Dimas Fauzi Maulana</h3>
                <p>"Sangat puas dengan layanan sewa mobil ini. Mobil bersih dan terawat, proses pemesanan mudah."</p>
            </div>
            <div class="testimonial-card">
                <img src="Asset/gibran3.png" alt="Fikri Rabbani Hariyanto">
                <h3>Fikri Rabbani Hariyanto</h3>
                <p>"Harga terjangkau dan pelayanan ramah. Pasti akan menggunakan jasa ini lagi."</p>
            </div>
            <div class="testimonial-card">
                <img src="Asset/hitler.png" alt="Muhammad Nur Fendiki">
                <h3>Muhammad Nur Fendiki</h3>
                <p>"Mobil yang disewakan dalam kondisi prima. Sangat direkomendasikan!"</p>
            </div>
        </div>
    </section>

    <section id="faq">
        <h2>FAQ</h2>
        <p>Selamat datang di bagian FAQ kami! Kami paham bahwa Anda mungkin memiliki banyak pertanyaan sebelum
            memutuskan untuk menyewa mobil. Oleh karena itu, kami telah mengumpulkan pertanyaan-pertanyaan yang sering
            diajukan beserta jawabannya untuk membantu Anda. Jika Anda tidak menemukan jawaban yang Anda cari, jangan
            ragu untuk menghubungi tim customer service kami. Kami siap membantu Anda dengan senang hati!</p>
        <div class="faq-grid">
            <div class="faq-item">
                <h3>Apa syarat untuk menyewa mobil?</h3>
                <p>Syarat utama adalah memiliki SIM yang masih berlaku dan KTP. Kami juga memerlukan deposit sebagai
                    jaminan.</p>
            </div>
            <div class="faq-item">
                <h3>Apakah mobil dilengkapi dengan asuransi?</h3>
                <p>Ya, semua mobil kami dilengkapi dengan asuransi komprehensif untuk keamanan Anda.</p>
            </div>
            <div class="faq-item">
                <h3>Bagaimana jika saya mengembalikan mobil terlambat?</h3>
                <p>Kami memiliki kebijakan denda untuk pengembalian yang terlambat. Silakan hubungi kami untuk informasi
                    lebih lanjut.</p>
            </div>
            <div class="faq-item">
                <h3>Bagaimana jika saya mengembalikan mobil terlambat?</h3>
                <p>Kami memiliki kebijakan denda untuk pengembalian yang terlambat. Silakan hubungi kami untuk informasi
                    lebih lanjut.</p>
            </div>
            <!-- Add more FAQ items as needed -->
        </div>
    </section>
    </main>

    <?php include 'footer/footer.php'; ?>
</body>

</html>

<script>
    // Fungsi untuk mengecek status login pengguna
    function isUserLoggedIn() {
        // Logika pengecekan login, misalnya dengan LocalStorage
        return localStorage.getItem("isLoggedIn") === "true";
    }

    // Fungsi untuk menghandle klik tombol sewa
    function checkRegistration(event) {
        event.preventDefault(); // Mencegah aksi default tombol
        console.log("Tombol Sewa diklik");

        if (!isUserLoggedIn()) {
            // Jika pengguna belum login, arahkan ke halaman login
            console.log("Pengguna belum login");
            alert("Silakan login terlebih dahulu untuk menyewa mobil.");
            window.location.href = "HalamanSewa/sewa.php";
        } else {
            // Jika pengguna sudah login, arahkan ke halaman sewa
            console.log("Pengguna sudah login");
            window.location.href = "HalamanSewa/sewa.php";
        }
    }
</script>