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
  <div class="container">
    <nav class="navbar">
      <img src="../Asset/logo.png" alt="Logo" class="logo" />
      <div class="nav-links">
        <a href="../Homepage/homepage.php">Home</a>
        <a href="../Listmobil/daftarmobildb.php">Daftar Mobil</a>
        <a href="../Aboutpage/about.php">About</a>
        <a href="../Kontak/Kontak.php">Contact</a>
      </div>
      <div class="user-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 25 25">
          <path
            d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm7.753 18.305c-.261-.586-.789-.991-1.871-1.241-2.293-.529-4.428-.993-3.393-2.945 3.145-5.942.833-9.119-2.489-9.119-3.388 0-5.644 3.299-2.489 9.119 1.066 1.964-1.148 2.427-3.393 2.945-1.084.25-1.608.658-1.867 1.246-1.405-1.723-2.251-3.919-2.251-6.31 0-5.514 4.486-10 10-10s10 4.486 10 10c0 2.389-.845 4.583-2.247 6.305z" />
        </svg>
      </div>
    </nav>

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
              <span>087774655731</span>
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