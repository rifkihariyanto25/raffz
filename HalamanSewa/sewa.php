<?php

require_once '../admin/config/config.php';

// Memastikan session ada
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu.");
}

// Ambil id_user dari session
$id_user = $_SESSION['user_id'];


$id_mobil = isset($_GET['id_mobil']) ? htmlspecialchars($_GET['id_mobil']) : '';
$nama_mobil = isset($_GET['nama_mobil']) ? htmlspecialchars($_GET['nama_mobil']) : '';
$harga_per_hari = isset($_GET['harga_per_hari']) ? htmlspecialchars($_GET['harga_per_hari']) : '';
$foto_mobil = isset($_GET['foto_mobil']) ? htmlspecialchars($_GET['foto_mobil']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate order ID
    $order_id = 'RAFFZ' . date('Ymd') . rand(1000, 9999);

    // Input data
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $whatsapp = htmlspecialchars($_POST['whatsapp']);
    $email = htmlspecialchars($_POST['email']);
    $pickup_location = htmlspecialchars($_POST['pickup_location']);
    $return_location = htmlspecialchars($_POST['return_location']);
    $pickup_date = htmlspecialchars($_POST['pickup_date']);
    $return_date = htmlspecialchars($_POST['return_date']);
    $total_price = htmlspecialchars($_POST['total_price']);
    $id_mobil = htmlspecialchars($_POST['id_mobil']);
    $special_notes = htmlspecialchars($_POST['special_notes']);

    // File Upload Handling
    $ktp_image = '';
    $sim_image = '';

    $ktp_target_dir = "../admin/index/ktp/";
    $sim_target_dir = "../admin/index/sim/";

    // Proses upload file KTP
    if (isset($_FILES['ktp_image']) && $_FILES['ktp_image']['error'] == UPLOAD_ERR_OK) {
        $ktp_file_name = uniqid() . '_' . basename($_FILES['ktp_image']['name']);
        $ktp_target_file = $ktp_target_dir . $ktp_file_name;

        if (move_uploaded_file($_FILES['ktp_image']['tmp_name'], $ktp_target_file)) {
            $ktp_image = $ktp_file_name;
        } else {
            die("Upload KTP gagal.");
        }
    }

    // Proses upload file SIM
    if (isset($_FILES['sim_image']) && $_FILES['sim_image']['error'] == UPLOAD_ERR_OK) {
        $sim_file_name = uniqid() . '_' . basename($_FILES['sim_image']['name']);
        $sim_target_file = $sim_target_dir . $sim_file_name;

        if (move_uploaded_file($_FILES['sim_image']['tmp_name'], $sim_target_file)) {
            $sim_image = $sim_file_name;
        } else {
            die("Upload SIM gagal.");
        }
    }

    // Validasi wajib isi
    if (empty($nama_lengkap) || empty($whatsapp) || empty($email) || empty($pickup_date) || empty($return_date) || empty($ktp_image) || empty($sim_image)) {
        die("Semua data wajib diisi, termasuk upload KTP dan SIM.");
    }

    // Insert query untuk menyimpan data pesanan, termasuk id_user
    $sql = "INSERT INTO bookings (order_id, nama_lengkap, whatsapp, email, pickup_location, return_location, pickup_date, return_date, total_price, id_mobil, ktp_image, sim_image, id_user, special_notes, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssss", $order_id, $nama_lengkap, $whatsapp, $email, $pickup_location, $return_location, $pickup_date, $return_date, $total_price, $id_mobil, $ktp_image, $sim_image, $id_user, $special_notes);
    if ($stmt->execute()) {
        header("Location: ../midtrans/examples/snap/simple.php?id_booking=$order_id");
        exit;
    } else {
        echo "Terjadi kesalahan saat menyimpan data.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAFFZ Car - Rental Booking</title>
    <link rel="stylesheet" href="style2.css?v=<?php echo time(); ?>" />
</head>

<body>
    <?php include '../navbar/navbar.php'; ?>

    <form action="" method="POST" enctype="multipart/form-data">

        <!-- <input type="hidden" name="id_user" value="<?= $_SESSION['id_user']; ?>"> -->
        <input type="hidden" name="id_mobil" value="<?= $id_mobil ?>">
        <input type="hidden" name="total_price" id="total_price_input" value="0">
        <div class="main-container">
            <div class="form-section">
                <h2>Informasi Pemesan</h2>
                <div class="card">
                    <div class="form-group">
                        <label>Nama Lengkap Sesuai KTP</label>
                        <input type="text" name="nama_lengkap" value="<?= $namaLengkap ?>" readonly required>
                    </div>
                    <div class="form-group">
                        <label>No. WhatsApp</label>
                        <input type="text" name="whatsapp" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= $email ?>" readonly required>
                    </div>
                </div>

                <h2>Detail Pemesanan</h2>
                <div class="card">
                    <div class="form-group">
                        <label>Lokasi Pengambilan</label>
                        <select name="pickup_location" required>
                            <option value="">Select one...</option>
                            <option value="Taman Andhang">Taman Andhang</option>
                            <option value="Moro">Moro</option>
                            <option value="Alun Alun">Alun Alun</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Pengembalian</label>
                        <select name="return_location" required>
                            <option value="">Select one...</option>
                            <option value="Kantor RAFFZ Car">Kantor RAFFZ Car</option>
                            <option value="Taman Andhang">Taman Andhang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pickup_date">Tanggal Pengambilan</label>
                        <input type="date" id="pickup_date" name="pickup_date" placeholder="Tanggal Pengambilan" required onchange="updateSummary()">
                    </div>
                    <div class="form-group">
                        <label for="return_date">Tanggal Pengembalian</label>
                        <input type="date" id="return_date" name="return_date" placeholder="Tanggal Pengembalian" required onchange="updateSummary()">
                    </div>


                    <div class="file-upload-container">
                        <label class="file-label">KTP</label>
                        <div class="file-upload-wrapper">
                            <label class="file-upload-button" for="ktp_image">Pilih File</label>
                            <input type="file" id="ktp_image" name="ktp_image" accept=".jpg,.jpeg" required>
                            <span id="ktp_file_info" class="file-info">Tidak ada file yang dipilih</span>
                        </div>
                        <div class="file-hint">*) Max 250kb, Format: .jpg</div>
                    </div>

                    <div class="file-upload-container">
                        <label class="file-label">SIM A</label>
                        <div class="file-upload-wrapper">
                            <label class="file-upload-button" for="sim_image">Pilih File</label>
                            <input type="file" id="sim_image" name="sim_image" accept=".jpg,.jpeg" required>
                            <span id="sim_file_info" class="file-info">Tidak ada file yang dipilih</span>
                        </div>
                        <div class="file-hint">*) Max 250kb, Format: .jpg</div>
                    </div>



                    <div class="form-group">
                        <label>Catatan Khusus</label>
                        <textarea name="special_notes" rows="3" id="special_notes" maxlength="200" oninput="checkWordCount(this)"></textarea>
                        <small id="word-counter" style="color: #666; font-size: 12px;">0/20 kata</small>
                    </div>
                </div>

                <div class="terms">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">Saya setuju dengan <a href="#">Syarat dan Ketentuan</a> di RAFFZ Car</label>
                </div>

                <div class="total-section">
                    <div class="total-price">
                        <strong>Total Harga</strong>
                        <strong id="total_price">Rp 0</strong>
                    </div>
                    <button type="submit" class="pay-button">Bayar Sekarang</button>
                </div>
            </div>

            <div class="summary-section sticky-summary">
                <h2>Ringkasan Pesanan</h2>
                <div class="card">
                    <div class="car-preview">
                        <img src="../admin/index/img/<?= $foto_mobil ?>" alt="Car Preview">
                    </div>
                    <div class="car-details">
                        <h3><?= $nama_mobil ?></h3>
                    </div>
                    <div class="summary-details">
                        <div>
                            <span>Tanggal Pengambilan</span>
                            <span id="pickup_date_summary">-</span>
                        </div>
                        <div>
                            <span>Tanggal Pengembalian</span>
                            <span id="return_date_summary">-</span>
                        </div>
                        <div>
                            <span>Durasi Sewa:</span>
                            <span id="duration_summary">-</span>
                        </div>
                        <div>
                            <span>Harga Per Hari:</span>
                            <span id="daily_price_summary">Rp<?= number_format($harga_per_hari, 0, ',', '.') ?></span>
                        </div>
                        <div>
                            <span>Total Harga:</span>
                            <span id="total_price_summary">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function updateSummary() {
            const pickupDateInput = document.getElementById('pickup_date');
            const returnDateInput = document.getElementById('return_date');
            const pickupDateSummary = document.getElementById('pickup_date_summary');
            const returnDateSummary = document.getElementById('return_date_summary');
            const durationSummary = document.getElementById('duration_summary');
            const dailyPriceSummary = document.getElementById('daily_price_summary');
            const totalPriceDisplay = document.getElementById('total_price');
            const totalPriceSummary = document.getElementById('total_price_summary');
            const totalPriceInput = document.getElementById('total_price_input');

            const pickupDate = pickupDateInput.value;
            const returnDate = returnDateInput.value;

            pickupDateSummary.textContent = pickupDate || '-';
            returnDateSummary.textContent = returnDate || '-';

            if (pickupDate && returnDate) {
                const pickup = new Date(pickupDate);
                const returnD = new Date(returnDate);

                if (returnD >= pickup) {
                    const duration = Math.ceil((returnD - pickup) / (1000 * 60 * 60 * 24)) + 1; // Tambah 1 hari untuk inklusivitas
                    durationSummary.textContent = `${duration} hari`;

                    const pricePerDay = <?= $harga_per_hari ?>;
                    const totalPrice = duration * pricePerDay;

                    // Update harga harian di ringkasan
                    dailyPriceSummary.textContent = `Rp${pricePerDay.toLocaleString('id-ID')}`;

                    // Update total harga
                    totalPriceDisplay.textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
                    totalPriceSummary.textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
                    totalPriceInput.value = totalPrice;
                } else {
                    durationSummary.textContent = '-';
                    totalPriceDisplay.textContent = 'Tanggal tidak valid';
                    totalPriceSummary.textContent = 'Tanggal tidak valid';
                    totalPriceInput.value = 0;
                }
            } else {
                durationSummary.textContent = '-';
                totalPriceDisplay.textContent = 'Rp0';
                totalPriceSummary.textContent = 'Rp0';
                totalPriceInput.value = 0;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const ktpInput = document.getElementById('ktp_image');
            const simInput = document.getElementById('sim_image');
            const ktpFileInfo = document.getElementById('ktp_file_info');
            const simFileInfo = document.getElementById('sim_file_info');

            ktpInput.addEventListener('change', () => {
                const fileName = ktpInput.files[0]?.name || "Tidak ada file yang dipilih";
                ktpFileInfo.textContent = fileName;
            });

            simInput.addEventListener('change', () => {
                const fileName = simInput.files[0]?.name || "Tidak ada file yang dipilih";
                simFileInfo.textContent = fileName;
            });
        });

        function checkWordCount(textarea) {
            const text = textarea.value;
            const words = text.trim().split(/\s+/);
            const wordCount = text.trim() === '' ? 0 : words.length;
            const wordCounter = document.getElementById('word-counter');

            wordCounter.textContent = `${wordCount}/20 kata`;

            if (wordCount > 20) {
                // Potong teks menjadi 20 kata saja
                textarea.value = words.slice(0, 20).join(' ');
                wordCounter.textContent = '20/20 kata';
                wordCounter.style.color = 'red';
            } else {
                wordCounter.style.color = '#666';
            }
        }

        // Tambahkan ke dalam event listener yang sudah ada
        document.addEventListener('DOMContentLoaded', () => {
            // ... kode yang sudah ada ...

            const specialNotes = document.getElementById('special_notes');
            if (specialNotes) {
                specialNotes.addEventListener('paste', (e) => {
                    setTimeout(() => checkWordCount(specialNotes), 0);
                });
            }
        });
    </script>
    <div class="wave-bottom"></div>
</body>

</html>