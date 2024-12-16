<?php
require_once '../admin/config/config.php';

if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu.");
}

$id_user = $_SESSION['user_id'];

// Query untuk mengambil data booking beserta informasi mobil dan user
$sql = "SELECT 
            b.booking_id,
            b.order_id,
            b.nama_lengkap,
            b.whatsapp,
            b.email,
            b.driver_option,
            b.pickup_date,
            b.return_date,
            b.pickup_location,
            b.return_location,
            b.created_at,
            b.status_konfirmasi,
            b.total_price,
            b.special_notes,
            m.nama_mobil,
            m.foto_mobil,
            DATE_FORMAT(b.pickup_date, '%d/%m/%Y, %H:%i') as formatted_pickup_date,
            DATE_FORMAT(b.return_date, '%d/%m/%Y, %H:%i') as formatted_return_date,
            DATE_FORMAT(b.created_at, '%d/%m/%Y, %H:%i') as formatted_created_at
        FROM bookings b 
        JOIN mobil m ON b.id_mobil = m.id_mobil 
        WHERE b.id_user = ?
        ORDER BY b.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_user);
$stmt->execute();
$result = $stmt->get_result();

?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Anda</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
</head>

<body>

    <div class="container">
        <h2 class="title">Pesanan Anda</h2>
        <p class="subtitle">Lihat riwayat pesanan dan pesanan anda yang sedang berlangsung</p>

        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="car-info">
                            <h3><?php echo htmlspecialchars($row['nama_mobil']); ?></h3>
                            <p>2023</p>
                            <img src="../admin/index/img/<?php echo htmlspecialchars($row['foto_mobil']); ?>"
                                alt="<?php echo htmlspecialchars($row['nama_mobil']); ?>">
                        </div>
                        <div class="order-details">
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>ID Pesanan</label>
                                    <p><?php echo htmlspecialchars($row['order_id']); ?></p>
                                </div>
                                <div class="info-item">
                                    <label>Tipe Transaksi</label>
                                    <p>Payment</p>
                                </div>
                                <div class="info-item" style="text-align: right;">
                                    <label>Status</label>
                                    <span class="status-pill sedang-diproses">
                                        <span class="status-pill <?php echo strtolower($row['status_konfirmasi']); ?>">
                                            <?php echo htmlspecialchars($row['status_konfirmasi']); ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Tanggal & Waktu</label>
                                    <p><?php echo $row['formatted_created_at']; ?></p>
                                </div>
                                <div class="info-item">
                                    <label>Channel</label>
                                    <p>DANA</p>
                                </div>
                                <div class="info-item">
                                    <p class="price">Rp <?php echo number_format($row['total_price'], 0, ',', '.'); ?></p>
                                    <button class="detail-toggle">Detail Pesanan ▼</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail-content">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Nama Pemesan</label>
                                <p><?php echo htmlspecialchars($row['nama_lengkap']); ?></p>
                            </div>
                            <div class="detail-item">
                                <label>No. WhatsApp</label>
                                <p><?php echo htmlspecialchars($row['whatsapp']); ?></p>
                            </div>
                            <div class="detail-item">
                                <label>Lokasi Pengambilan</label>
                                <p><?php echo htmlspecialchars($row['pickup_location']); ?></p>
                            </div>
                        </div>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Email</label>
                                <p><?php echo htmlspecialchars($row['email']); ?></p>
                            </div>
                            <div class="detail-item">
                                <label>Waktu Peminjaman</label>
                                <p><?php echo $row['formatted_pickup_date']; ?></p>
                            </div>
                            <div class="detail-item">
                                <label>Lokasi Pengembalian</label>
                                <p><?php echo htmlspecialchars($row['return_location']); ?></p>
                            </div>
                        </div>
                        <div class="detail-grid">
                            <div class="detail-item">
                                <label>Waktu Pengembalian</label>
                                <p><?php echo $row['formatted_return_date']; ?></p>
                            </div>
                            <div class="detail-item catatan">
                                <label>Catatan Khusus</label>
                                <textarea readonly><?php echo htmlspecialchars($row['special_notes']); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<div class="no-orders"><p>Tidak ada pesanan ditemukan.</p></div>';
        }
        ?>

        <div class="order-card">
            <div class="order-header">
                <div class="car-info">
                    <h3>Mitsubishi Xpander</h3>
                    <p>2023</p>
                    <img src="../Asset/xpander.png" alt="Mitsubishi Xpander">
                </div>
                <div class="order-details">
                    <div class="info-grid">
                        <div class="info-item">
                            <label>ID Pesanan</label>
                            <p>XP1001</p>
                        </div>
                        <div class="info-item">
                            <label>Tipe Transaksi</label>
                            <p>Payment</p>
                        </div>
                        <div class="info-item" style="text-align: right;">
                            <label>Status</label>
                            <span class="status-pill terlambat">Terlambat</span>
                        </div>
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Tanggal & Waktu</label>
                            <p>19/10/2024, 17:15</p>
                        </div>
                        <div class="info-item">
                            <label>Channel</label>
                            <p>DANA</p>
                        </div>
                        <div class="info-item price-section">
                            <div class="price-wrapper">
                                <div class="warning-icon">
                                    !
                                    <div class="warning-tooltip">
                                        Keterlambatan 1 jam pertama bebas denda. Setelahnya, denda dihitung per 1 hari
                                        <div class="late-fee">
                                            Jumlah Denda: Rp 150.000/hari
                                        </div>
                                    </div>
                                </div>
                                <p class="price">Rp 499.000</p>
                            </div>
                            <a href="#" class="detail-toggle">Detail Pesanan ▼</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="detail-content">
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Nama Pemesan</label>
                        <p>Ridwan Mirsod</p>
                    </div>
                    <div class="detail-item">
                        <label>No. WhatsApp</label>
                        <p>085267739885</p>
                    </div>
                    <div class="detail-item">
                        <label>Waktu Jemput</label>
                        <p>21/10/2024, 09:00</p>
                    </div>
                </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Email</label>
                        <p>ridwanm88@gmail.com</p>
                    </div>
                    <div class="detail-item">
                        <label>Jenis Rental</label>
                        <p>Dengan Sopir</p>
                    </div>
                    <div class="detail-item">
                        <label>Waktu Kembali</label>
                        <p>22/10/2024, 09:00</p>
                    </div>
                    <div class="detail-item catatan">
                        <label>Catatan Khusus</label>
                        <textarea readonly></textarea>
                    </div>
                </div>
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