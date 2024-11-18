<?php
include '../admin/config/config.php'; // Menghubungkan ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];
    $driver_option = $_POST['driver_option'];
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];

    // Menyiapkan statement SQL untuk memasukkan data
    $sql = "INSERT INTO bookings (nama_lengkap, whatsapp, email, driver_option, pickup_location, return_location, pickup_date, return_date, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $nama_lengkap, $whatsapp, $email, $driver_option, $pickup_location, $return_location, $pickup_date, $return_date);

    // Eksekusi statement
    if ($stmt->execute()) {
        header("Location: ../HalamanPembayaran/index.php");
        exit();
    } else {
        error_log("SQL Error: " . $stmt->error); // Catat kesalahan ke log server
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }


    // Menutup statement dan koneksi
    $stmt->close();
    $conn->close();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_booking']) && isset($_POST['konfirmasi'])) {
    $booking_id = intval($_POST['id_booking']);
    $sql = "UPDATE bookings SET status_konfirmasi = 'Sudah Dikonfirmasi' WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('i', $booking_id);

    if ($stmt->execute()) {
        echo "Pesanan berhasil dikonfirmasi!";
        header("Location: manage_mobil.php#bookingPage");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raffz Car - Halaman Sewa</title>
    <link rel="stylesheet" href="sewa.css">
</head>

<body>

    <header>
        <nav>
            <div class="logo">
                <img src="../Asset/logo.png">
            </div>
            <ul>
                <li><a href="/Homepage/homepage.html">Home</a></li>
                <li><a href="../Listmobil/daftarmobil.html">Daftar Mobil</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="user-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm7.753 18.305c-.261-.586-.789-.991-1.871-1.241-2.293-.529-4.428-.993-3.393-2.945 3.145-5.942.833-9.119-2.489-9.119-3.388 0-5.644 3.299-2.489 9.119 1.066 1.964-1.148 2.427-3.393 2.945-1.084.25-1.608.658-1.867 1.246-1.405-1.723-2.251-3.919-2.251-6.31 0-5.514 4.486-10 10-10s10 4.486 10 10c0 2.389-.845 4.583-2.247 6.305z" />
                </svg>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="main-content">
            <div class="form-section">
                <h2>Informasi Pemesan</h2>

                <form method="post">
                    <div class="form-group">
                        <label>Nama Lengkap (Sesuai KTP)</label>
                        <input type="text" name="nama_lengkap" placeholder="Nama lengkap" required>
                    </div>

                    <div class="form-group">
                        <label>No. WhatsApp</label>
                        <input type="tel" name="whatsapp" placeholder="Nomor WhatsApp" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <h3>Pilihan Sopir</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" name="driver_option" value="Dengan Sopir" id="agree" onchange="showDriverForm()" required>
                                <label for="agree">Dengan Sopir</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="driver_option" value="Lepas Kunci" id="disagree" onchange="showSelfDriveForm()" required>
                                <label for="disagree">Lepas Kunci</label>
                            </div>
                        </div>
                    </div>

            </div>


            <div class="form-section driver-form" style="display: none;">
                <h2>Detail Pemesanan</h2>
                <div class="form-group">
                    <h3>Alur Lokasi</h3>
                    <label for="pickup_location">Lokasi Jemput</label>
                    <input type="text" id="pickup_location" name="pickup_location" placeholder="Pilih lokasi jemput" onclick="openMap('pickup')" required>
                </div>
                <div class="form-group">
                    <label for="return_location">Lokasi Pengembalian</label>
                    <input type="text" id="return_location" name="return_location" placeholder="Pilih lokasi pengembalian" onclick="openMap('return')" required>
                </div>

                <div class="form-group">
                    <h3>Alur Tanggal</h3>
                    <input type="date" name="pickup_date" placeholder="Tanggal Pengambilan" required>
                </div>
                <div class="form-group">
                    <input type="date" name="return_date" placeholder="Tanggal Pengembalian" required>
                </div>


            </div>

            <div class="form-section self-drive-form" style="display: none;">
                <h2>Detail Pemesanan</h2>
                <div class="form-group">
                    <h3>Alur Lokasi</h3>
                    <select>
                        <option>Lokasi Pengambilan</option>
                    </select>
                </div>
                <div class="form-group">
                    <select>
                        <option>Lokasi Pengembalian</option>
                    </select>
                </div>

                <div class="form-group">
                    <h3>Alur Tanggal</h3>
                    <input type="date" placeholder="Tanggal Pengambilan">
                </div>
                <div class="form-group">
                    <input type="date" placeholder="Tanggal Pengembalian">
                </div>


            </div>

        </div>
        <div class="summary-section sticky-summary">
            <div class="summary-card">
                <h2>Ringkasan Pesanan</h2>
                <div class="car-preview">
                    <img src="/Asset/alphard.png" alt="Car Preview">
                    <div class="car-details">
                        <h3>Mitsubishi Xpander</h3>
                        <p>By Admin</p>
                    </div>
                </div>

                <div class="detail-row">
                    <span>Tanggal Pengambilan</span>
                    <span>22/10/2024</span>
                </div>
                <div class="detail-row">
                    <span>Tanggal Pengembalian</span>
                    <span>23/10/2024</span>
                </div>
            </div>
        </div>

        <div class="total-section">
            <div class="total-section-card">
                <div class="detail-row">
                    <strong>Total Harga</strong>
                    <strong>Rp450.000</strong>
                </div>
                <input type="text" placeholder="Kode Unik Pembayaran" class="payment-input">
                <button type="submit" class="submit-btn">BUAT PESANAN</button>
            </div>
        </div>
    </div>
    </form>
    <div class="wave-bg"></div>
</body>

</html>

<script>
    function showDriverForm() {
        const driverForm = document.querySelector('.driver-form');
        const selfDriveForm = document.querySelector('.self-drive-form');
        const summarySection = document.querySelector('.summary-section');

        driverForm.style.display = 'block';
        selfDriveForm.style.display = 'none';
        summarySection.style.display = 'block';
    }

    function showSelfDriveForm() {
        const driverForm = document.querySelector('.driver-form');
        const selfDriveForm = document.querySelector('.self-drive-form');
        const summarySection = document.querySelector('.summary-section');

        driverForm.style.display = 'none';
        selfDriveForm.style.display = 'block';
        summarySection.style.display = 'block';
    }
</script>

<script>
    // Fungsi untuk membuka Google Maps dan memilih lokasi
    function openMap(locationType) {
        let baseUrl = "https://www.google.com/maps/search/?api=1&query=";
        let locationPrompt = locationType === 'pickup' ? 'Masukkan lokasi jemput' : 'Masukkan lokasi pengembalian';
        let location = prompt(locationPrompt); // Meminta input lokasi dari pengguna

        if (location) {
            let mapUrl = baseUrl + encodeURIComponent(location);
            window.open(mapUrl, '_blank'); // Membuka Google Maps di tab baru

            // Menyimpan lokasi yang dipilih ke input yang sesuai
            if (locationType === 'pickup') {
                document.getElementById('pickup_location').value = location;
            } else {
                document.getElementById('return_location').value = location;
            }

            // Menampilkan konfirmasi dan mengarahkan kembali ke form
            alert("Lokasi telah terisi. Silakan lanjutkan pengisian form.");
        }
    }

    // Fungsi untuk membuka Google Maps saat klik form
    function openMapsOnClick(inputId, locationType) {
        document.getElementById(inputId).addEventListener('click', function() {
            openMap(locationType);
        });
    }

    // Inisialisasi event listener untuk form klik
    document.addEventListener('DOMContentLoaded', function() {
        openMapsOnClick('pickup_location', 'pickup'); // Untuk form penjemputan
        openMapsOnClick('return_location', 'return'); // Untuk form pengembalian
    });
</script>