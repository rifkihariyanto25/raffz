<?php
include '../admin/config/config.php';

$id_mobil = isset($_GET['id_mobil']) ? htmlspecialchars($_GET['id_mobil']) : '';
$nama_mobil = isset($_GET['nama_mobil']) ? htmlspecialchars($_GET['nama_mobil']) : '';
$harga_per_hari = isset($_GET['harga_per_hari']) ? htmlspecialchars($_GET['harga_per_hari']) : '';
$foto_mobil = isset($_GET['foto_mobil']) ? htmlspecialchars($_GET['foto_mobil']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $order_id = 'RAFFZ' . date('Ymd') . rand(1000, 9999);
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $whatsapp = htmlspecialchars($_POST['whatsapp']);
    $email = htmlspecialchars($_POST['email']);
    $driver_option = htmlspecialchars($_POST['driver_option']);
    $pickup_location = htmlspecialchars($_POST['pickup_location']);
    $return_location = htmlspecialchars($_POST['return_location']);
    $pickup_date = htmlspecialchars($_POST['pickup_date']);
    $return_date = htmlspecialchars($_POST['return_date']);
    $total_price = htmlspecialchars($_POST['total_price']);
    $id_mobil = htmlspecialchars($_POST['id_mobil']);

    // Cek jika ada data yang kosong
    if (empty($nama_lengkap) || empty($whatsapp) || empty($email) || empty($pickup_date) || empty($return_date)) {
        die("Semua data wajib diisi.");
    }

    // Insert query untuk menyimpan data pesanan
    $sql = "INSERT INTO bookings (order_id, nama_lengkap, whatsapp, email, driver_option, pickup_location, return_location, pickup_date, return_date, total_price, id_mobil, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $order_id, $nama_lengkap, $whatsapp, $email, $driver_option, $pickup_location, $return_location, $pickup_date, $return_date, $total_price, $id_mobil);

    if ($stmt->execute()) {
        header("Location: ../midtrans/examples/snap/simple.php?id_booking=$order_id");

        exit;
    } else {
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }

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
    <link rel="stylesheet" href="sewa.css?v=<?php echo time(); ?>" />
</head>

<body>
    <?php include '../navbar/navbar.php'; ?>

    <div class="container">
        <form action="" method="POST">
            <!-- Hidden inputs for id_mobil and total_price -->
            <input type="hidden" name="id_mobil" value="<?= $id_mobil ?>">
            <input type="hidden" name="total_price" id="total_price_input" value="0">

            <div class="main-content">
                <div class="form-section">
                    <h2>Informasi Pemesan</h2>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input
                            type="text"
                            name="nama_lengkap"
                            value="<?= $namaLengkap ?>"
                            readonly
                            required>
                    </div>

                    <div class="form-group">
                        <label>No. WhatsApp</label>
                        <input type="tel" name="whatsapp" placeholder="Nomor WhatsApp" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            value="<?= $email ?>"
                            readonly
                            required>
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
                        <label for="pickup_date">Tanggal Pengambilan</label>
                        <input type="date" id="pickup_date" name="pickup_date" placeholder="Tanggal Pengambilan" required oninput="updateSummary()">
                    </div>
                    <div class="form-group">
                        <label for="return_date">Tanggal Pengembalian</label>
                        <input type="date" id="return_date" name="return_date" placeholder="Tanggal Pengembalian" required oninput="updateSummary()">
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
                        <img src="../admin/index/img/<?= $foto_mobil ?>" alt="Car Preview">
                    </div>
                    <div class="car-details">
                        <h3><?= $nama_mobil ?></h3>
                    </div>
                    <div class="detail-row">
                        <span>Tanggal Pengambilan</span>
                        <span id="pickup_date_summary">-</span>
                    </div>
                    <div class="detail-row">
                        <span>Tanggal Pengembalian</span>
                        <span id="return_date_summary">-</span>
                    </div>
                </div>
            </div>

            <div class="total-section">
                <div class="total-section-card">
                    <div class="detail-row">
                        <strong>Total Harga</strong>
                        <strong id="total_price">Rp0</strong>
                    </div>
                    <button type="submit" class="submit-btn">BUAT PESANAN</button>
                </div>
            </div>
        </form>
    </div>

    <div class="wave-bg"></div>

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

        function updateSummary() {
            const pickupDate = document.getElementById('pickup_date').value;
            const returnDate = document.getElementById('return_date').value;

            document.getElementById('pickup_date_summary').textContent = pickupDate || '-';
            document.getElementById('return_date_summary').textContent = returnDate || '-';

            if (pickupDate && returnDate) {
                const pickup = new Date(pickupDate);
                const returnD = new Date(returnDate);

                const timeDiff = returnD - pickup;
                let daysDiff = timeDiff / (1000 * 60 * 60 * 24);

                daysDiff = daysDiff >= 0 ? daysDiff + 1 : 0;

                if (daysDiff > 0) {
                    const pricePerDay = <?= $harga_per_hari ?>;
                    const totalPrice = daysDiff * pricePerDay;

                    // Update tampilan total price
                    document.getElementById('total_price').textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
                    // Update hidden input value
                    document.getElementById('total_price_input').value = totalPrice;
                } else {
                    document.getElementById('total_price').textContent = 'Tanggal tidak valid';
                    document.getElementById('total_price_input').value = 0;
                }
            } else {
                document.getElementById('total_price').textContent = 'Rp0';
                document.getElementById('total_price_input').value = 0;
            }
        }

        function initializeLocationInputs() {
            const pickupInput = document.getElementById('pickup_location');
            const returnInput = document.getElementById('return_location');

            pickupInput.addEventListener('click', () => openLocationPicker('pickup'));
            returnInput.addEventListener('click', () => openLocationPicker('return'));
        }

        function openLocationPicker(type) {
            const input = document.getElementById(`${type}_location`);
            const location = prompt('Masukkan lokasi:');
            if (location) {
                input.value = location;
            }
        }

        document.addEventListener('DOMContentLoaded', initializeLocationInputs);
    </script>
</body>

</html>