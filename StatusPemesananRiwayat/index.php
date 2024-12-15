<?php

include '../admin/config/config.php';

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Filter berdasarkan status
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';

// Query untuk mengambil data booking dan data mobil
$query = "SELECT b.*, m.nama_mobil, m.foto_mobil, m.harga_per_hari FROM bookings b
          JOIN mobil m ON b.id_mobil = m.id_mobil
          WHERE b.email = ?";

if ($status_filter !== 'all') {
    $query .= " AND b.status_pesanan = ?";
}

$stmt = $conn->prepare($query);
if ($status_filter !== 'all') {
    $stmt->bind_param("ss", $email, $status_filter);
} else {
    $stmt->bind_param("s", $email);
}

$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
</head>

<body>
    <?php include '../navbar/navbar.php'; ?>

    <div class="container">
        <h2 class="title">Pesanan Anda</h2>
        <p class="subtitle">Lihat riwayat pesanan dan pesanan anda yang sedang berlangsung</p>

        <?php if (empty($pesanan)): ?>
            <p>Tidak ada pesanan yang ditemukan.</p>
        <?php else: ?>
            <?php foreach ($pesanan as $order): ?>
                <section class="order-card">
                    <div class="order-header">
                        <div class="car-info">
                            <h3><?= htmlspecialchars($order['nama_mobil']) ?></h3>
                            <img src="../admin/uploads/<?= htmlspecialchars($order['foto_mobil']) ?>" alt="Foto mobil <?= htmlspecialchars($order['nama_mobil']) ?>" class="car-image">
                        </div>
                        <div class="order-details">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>ID Pesanan</label>
                                    <p><?= htmlspecialchars($order['order_id']) ?></p>
                                </div>
                                <div class="info-item">
                                    <label>Tipe Transaksi</label>
                                    <p>Payment</p>
                                </div>
                                <div class="info-item" style="text-align: right;">
                                    <label>Status</label>
                                    <span class="status-pill 
                                    <?php
                                    switch (strtolower($order['status_pesanan'])) {
                                        case 'pending':
                                            echo 'status-pending';
                                            break;
                                        case 'ongoing':
                                            echo 'status-ongoing';
                                            break;
                                        case 'completed':
                                            echo 'status-completed';
                                            break;
                                        case 'canceled':
                                            echo 'status-canceled';
                                            break;
                                    }
                                    ?>">
                                        <?= htmlspecialchars($order['status_pesanan']) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Tanggal & Waktu</label>
                                    <p><?= date('d/m/Y, H:i', strtotime($order['created_at'])) ?></p>
                                </div>
                                <div class="info-item">
                                    <label>Jenis Sewa</label>
                                    <p><?= htmlspecialchars($order['driver_option']) ?></p>
                                </div>
                                <div class="info-item">
                                    <p class="price">Rp<?= number_format($order['harga_per_hari'], 0, ',', '.') ?></p>
                                    <button class="detail-toggle">Detail Pesanan ▼</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail-content">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Nama Pemesan</label>
                                <p><?= htmlspecialchars($order['nama_lengkap']) ?></p>
                            </div>
                            <div class="detail-item">
                                <label>No. WhatsApp</label>
                                <p><?= htmlspecialchars($order['whatsapp']) ?></p>
                            </div>
                            <div class="detail-item">
                                <label>Waktu Jemput</label>
                                <p><?= date('d/m/Y, H:i', strtotime($order['pickup_date'])) ?></p>
                            </div>
                        </div>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Email</label>
                                <p><?= htmlspecialchars($order['email']) ?></p>
                            </div>
                            <div class="detail-item">
                                <label>Jenis Rental</label>
                                <p><?= htmlspecialchars($order['driver_option']) ?></p>
                            </div>
                            <div class="detail-item">
                                <label>Waktu Kembali</label>
                                <p><?= date('d/m/Y, H:i', strtotime($order['return_date'])) ?></p>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        document.querySelectorAll('.detail-toggle').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const card = this.closest('.order-card');
                const detailContent = card.querySelector('.detail-content');
                const arrow = this.innerHTML.includes('▼') ? '▲' : '▼';

                detailContent.classList.toggle('active');
                this.innerHTML = `Detail Pesanan ${arrow}`;
            });
        });
    </script>
</body>

</html>