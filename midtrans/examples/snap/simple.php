<?php

namespace Midtrans;

include '../../../admin/config/config.php';
require_once dirname(__FILE__) . '/../../Midtrans.php';

// Set Your server key
Config::$serverKey = 'SB-Mid-server-dvOaJBd7FgZMQus1K7EutjPN';
Config::$clientKey = 'SB-Mid-client-oyLsocrltTJE_7W9';

// Uncomment for production environment
// Config::$isProduction = true;
Config::$isSanitized = Config::$is3ds = true;

$order_id = isset($_GET['id_booking']) ? $_GET['id_booking'] : null;

if (!$order_id) {
    die("ID booking tidak ditemukan.");
}

// Query untuk mengambil data booking dari database
$query = "SELECT * FROM bookings WHERE order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$booking_data = $result->fetch_assoc();

if (!$booking_data) {
    die("Data booking tidak ditemukan.");
}

// Mengambil data mobil berdasarkan id_mobil dari tabel 'mobil'
$query_mobil = "SELECT * FROM mobil WHERE id_mobil = ?";
$stmt_mobil = $conn->prepare($query_mobil);
$stmt_mobil->bind_param("i", $booking_data['id_mobil']);
$stmt_mobil->execute();
$result_mobil = $stmt_mobil->get_result();
$mobil_data = $result_mobil->fetch_assoc();

if (!$mobil_data) {
    die("Data mobil tidak ditemukan.");
}

// Required
$transaction_details = array(
    'order_id' => $order_id,
    'gross_amount' => $booking_data['total_price'], // Nilai dari kolom total_price
);

// Optional
$item_details = array(
    array(
        'id' => 'rental',
        'price' => $booking_data['total_price'],
        'quantity' => 1,
        'name' => "Rental Mobil - " . $mobil_data['nama_mobil'] . " - " . $booking_data['driver_option'],
    ),
);

// Optional
$customer_details = array(
    'first_name'    => explode(' ', $booking_data['nama_lengkap'])[0],
    'last_name'     => explode(' ', $booking_data['nama_lengkap'], 2)[1] ?? '',
    'email'         => $booking_data['email'],
    'phone'         => $booking_data['whatsapp'],
);

// Fill transaction details
$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

// Generate snap token
$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
} catch (\Exception $e) {
    echo $e->getMessage();
    die();
}

$created_time = strtotime($booking_data['created_at']);
$payment_deadline = date('H:i A', strtotime('+60 minutes', $created_time));

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="../../../HalamanPembayaran/style.css?v=<?php echo time(); ?>" />
</head>

<body>

    <div class="container">
        <div class="main-content">
            <div class="left-section">
                <h2 class="section-title">Konfirmasi Pembayaran</h2>

                <div class="card">
                    <div class="timer-section">
                        <div class="timer-icon">⏰</div>
                        <div>
                            <p class="value">Selesaikan pembayaran sebelum</p>
                            <p class="value"><?= $payment_deadline ?></p>
                            <p class="label">Selesaikan dalam 60 menit</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="transfer-details">
                        <p class="label">Transfer ke</p>
                        <p class="value">Rafzz Car</p>
                        <div class="account-number">
                            <span>081</span>
                            <button class="copy-button" onclick="copyToClipboard('081')">Salin</button>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="payment-amount">
                        <p class="label">Jumlah Bayar</p>
                        <p class="value">Rp <?= number_format($booking_data['total_price'], 0, ',', '.') ?></p>
                        <button class="copy-button" onclick="showPaymentDetails()">Rincian</button>
                    </div>
                </div>

                <div>
                    <h3 class="section-title2">Sudah Menyelesaikan Transaksi?</h3>
                    <p class="label2" style="margin-bottom: 1rem">Setelah pembayaran Anda dikonfirmasi, kami akan mengirim bukti rental ke email anda</p>
                    <button class="submit-button" id="pay-button">Bayar Sekarang</button>
                </div>
            </div>

            <div class="right-section">
                <h2 class="section-title">Ringkasan Pesanan</h2>

                <div class="card">
                    <p style="margin-bottom: 1rem"><?= $booking_data['driver_option'] ?></p>

                    <div class="car-image-container">
                        <img src="../../../admin/index/img/<?= $mobil_data['foto_mobil'] ?>" alt="<?= $mobil_data['nama_mobil'] ?>" class="car-image" />
                    </div>

                    <div class="car-details">
                        <div>
                            <h3 class="value"><?= $mobil_data['nama_mobil'] ?></h3>
                            <p class="label">2023</p>
                        </div>
                        <p class="value">Rp <?= number_format($booking_data['total_price'], 0, ',', '.') ?></p>
                    </div>

                    <div class="dates">
                        <p>Tanggal Pengambilan: <span><?= date('d/m/Y', strtotime($booking_data['pickup_date'])) ?></span></p>
                        <p>Tanggal Pengembalian: <span><?= date('d/m/Y', strtotime($booking_data['return_date'])) ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey; ?>"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken yang didapat dari backend
            snap.pay('<?php echo $snap_token ?>');
        };
    </script>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            alert('Nomor rekening berhasil disalin!');
        }

        function showPaymentDetails() {
            alert('Total Pembayaran: Rp <?= number_format($booking_data['total_price'], 0, ',', '.') ?>');
        }

        // Timer countdown
        const deadline = new Date('<?= date('Y-m-d H:i:s', strtotime('+60 minutes', $created_time)) ?>').getTime();

        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = deadline - now;

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.querySelector('.timer-section .label').innerHTML =
                `Selesaikan dalam ${minutes} menit ${seconds} detik`;

            if (distance < 0) {
                clearInterval(timer);
                document.querySelector('.timer-section .label').innerHTML = "Waktu pembayaran habis";
            }
        }, 1000);
    </script>
</body>

</html>