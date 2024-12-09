<?php

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
              <p class="value">00.15 AM</p>
              <p class="label">Selesaikan dalam 60 menit</p>
            </div>
          </div>

          <div class="divider"></div>

          <div class="transfer-details">
            <p class="label">Transfer ke</p>
            <p class="value">Rafzz Car</p>
            <div class="account-number">
              <span>081</span>
              <button class="copy-button">Salin</button>
            </div>
          </div>

          <div class="divider"></div>

          <div class="payment-amount">
            <p class="label">Jumlah Bayar</p>
            <p class="value">Rp 499.000</p>
            <button class="copy-button">Rincian</button>
          </div>
        </div>

        <div>
          <h3 class="section-title2">Sudah Menyelesaikan Transaksi?</h3>
          <p class="label2" style="margin-bottom: 1rem">Setelah pembayaran Anda dikonfirmasi, kami akan mengirim bukti rental ke email anda</p>
          <button class="submit-button">Saya Sudah Bayar</button>
        </div>
      </div>

      <div class="right-section">
        <h2 class="section-title">Ringkasan Pesanan</h2>

        <div class="card">
          <p style="margin-bottom: 1rem">Dengan Sopir</p>

          <div class="car-image-container">
            <img src="../Asset/xpander.png" alt="Mitsubishi Xpander" class="car-image" />
          </div>

          <div class="car-details">
            <div>
              <h3 class="value">Mitsubishi Xpander</h3>
              <p class="label">2023</p>
            </div>
            <p class="value">Rp 399.000</p>
          </div>

          <div class="dates">
            <p>Tanggal Pengambilan: <span>22/10/2024</span></p>
            <p>Tanggal Pengembalian: <span>23/10/2024</span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>