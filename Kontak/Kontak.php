<?php
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

$current_page = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffz Car - Contact</title>
    <link rel="stylesheet" href="kontak.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php include '../navbar/navbar.php'; ?>

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


</body>

</html>