<?php
session_start();
include '../admin/config/config.php';

if (isset($_POST['submit_kritik'])) {
    // Ambil data dari form
    $nama_depan = mysqli_real_escape_string($conn, $_POST['nama_depan']);
    $nama_belakang = mysqli_real_escape_string($conn, $_POST['nama_belakang']);
    $nama_pengirim = $nama_depan . " " . $nama_belakang;
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $kritik_saran = mysqli_real_escape_string($conn, $_POST['kritik_saran']);

    // Query untuk insert data
    $query = "INSERT INTO kritiksaran (namapengirim, email, kritiksaran) 
              VALUES ('$nama_pengirim', '$email', '$kritik_saran')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Terima kasih! Kritik dan saran Anda telah terkirim.');
                window.location.href = 'kontak.php';
              </script>";
    } else {
        echo "<script>
                alert('Maaf, terjadi kesalahan. Silakan coba lagi: " . mysqli_error($conn) . "');
                window.location.href = 'kontak.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffz Car - Contact</title>
    <link rel="stylesheet" href="kontak.css">
</head>

<body>
    <header>
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
                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm7.753 18.305c-.261-.586-.789-.991-1.871-1.241-2.293-.529-4.428-.993-3.393-2.945 3.145-5.942.833-9.119-2.489-9.119-3.388 0-5.644 3.299-2.489 9.119 1.066 1.964-1.148 2.427-3.393 2.945-1.084.25-1.608.658-1.867 1.246-1.405-1.723-2.251-3.919-2.251-6.31 0-5.514 4.486-10 10-10s10 4.486 10 10c0 2.389-.845 4.583-2.247 6.305z" />
                </svg>
            </div>
        </nav>
    </header>

    <div class="contact-container">
        <h1 class="contact-title">Kontak Kami</h1>
        <p class="contact-subtitle">Saran dan kritik akan kami terima dengan sebaik mungkin</p>

        <div class="contact-content">
            <form class="contact-form" method="POST" action="">
                <div class="form-row">
                    <input type="text" name="nama_depan" placeholder="Nama Depan" required>
                    <input type="text" name="nama_belakang" placeholder="Nama Belakang" required>
                </div>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="kritik_saran" placeholder="Kritik dan Saran" required></textarea>
                <button type="submit" name="submit_kritik" class="submit-btn">Kirim Pesan</button>
            </form>

            <div class="contact-info">
                <h2>Alamat Kami</h2>
                <p><strong>Alamat Lengkap:</strong><br>
                    Musholla Baitul Khoiriyah
                    H67Q+6P6, Jl. Patriot, Gandasuli, Karangpucung, Kec. Purwokerto Sel., Kabupaten Banyumas, Jawa Tengah 53142</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.26596825065786!2d109.23917293655015!3d-7.4369568439838805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655f1af71bf93f%3A0x6d2c2e190899465a!2sMusholla%20Baitul%20Khoiriyah!5e0!3m2!1sid!2sid!4v1731925143542!5m2!1sid!2sid" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                <p><strong>No. WhatsApp:</strong><br>
                    08292786143</p>

                <p><strong>Email</strong><br>
                    RaffzCar@gmail.com</p>
            </div>
        </div>
    </div>

    <!-- <div class="wave-shape">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
        </svg>
    </div> -->
</body>

</html>