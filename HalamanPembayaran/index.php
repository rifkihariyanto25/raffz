<?php
include '../admin/config/config.php';

$order_id = isset($_GET['id_booking']) ? $_GET['id_booking'] : '';

$sql = "SELECT b.*, m.nama_mobil, m.foto_mobil 
        FROM bookings b
        LEFT JOIN mobil m ON b.id_mobil = m.id_mobil
        WHERE b.order_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

$created_time = strtotime($booking['created_at']);
$payment_deadline = date('H:i A', strtotime('+60 minutes', $created_time));

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php include '../navbar/navbar.php'; ?>
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
                        <p class="value">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></p>
                        <button class="copy-button" onclick="showPaymentDetails()">Rincian</button>
                    </div>
                </div>

                <div>
                    <h3 class="section-title2">Sudah Menyelesaikan Transaksi?</h3>
                    <p class="label2" style="margin-bottom: 1rem">Setelah pembayaran Anda dikonfirmasi, kami akan mengirim bukti rental ke email anda</p>
                    <button class="submit-button" onclick="confirmPayment('<?= $order_id ?>')">Saya Sudah Bayar</button>
                </div>
            </div>

            <div class="right-section">
                <h2 class="section-title">Ringkasan Pesanan</h2>

                <div class="card">
                    <p style="margin-bottom: 1rem"><?= $booking['driver_option'] ?></p>

                    <div class="car-image-container">
                        <img src="../uploads/<?= $booking['foto_mobil'] ?>" alt="<?= $booking['nama_mobil'] ?>" class="car-image" />
                    </div>

                    <div class="car-details">
                        <div>
                            <h3 class="value"><?= $booking['nama_mobil'] ?></h3>
                            <p class="label">2023</p>
                        </div>
                        <p class="value">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></p>
                    </div>

                    <div class="dates">
                        <p>Tanggal Pengambilan: <span><?= date('d/m/Y', strtotime($booking['pickup_date'])) ?></span></p>
                        <p>Tanggal Pengembalian: <span><?= date('d/m/Y', strtotime($booking['return_date'])) ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            alert('Nomor rekening berhasil disalin!');
        }

        function showPaymentDetails() {
            alert('Total Pembayaran: Rp <?= number_format($booking['total_price'], 0, ',', '.') ?>');
        }

        function confirmPayment(orderId) {
            // Kirim ke halaman konfirmasi atau proses pembayaran
            window.location.href = '../midtrans/examples/snap/simple.php?id_booking=$order_id';
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