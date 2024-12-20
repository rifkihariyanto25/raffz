<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Anda</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
</head>

<body>
    <?php include '../navbar/navbar.php'; ?>
    <div class="container">


        <h2 class="title">Pesanan Anda</h2>
        <p class="subtitle">Lihat riwayat pesanan dan pesanan anda yang sedang berlangsung</p>

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
                            <span class="status-pill sedang-diproses">Sedang Diproses</span>
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
                        <div class="info-item">
                            <p class="price">Rp 499.000</p>
                            <button class="detail-toggle">Detail Pesanan ▼</button>
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
        </div>
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