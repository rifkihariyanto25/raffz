<?php
$sopir_result = $conn->query("SELECT * FROM sopir");
$mobil_result = $conn->query("SELECT * FROM mobil");
$booking_result = $conn->query("SELECT * FROM bookings");


$total_transaksi = $booking_result->num_rows;
$total_sopir = $sopir_result->num_rows;

$mobil_result = $conn->query("SELECT SUM(jumlah_unit) AS total_unit FROM mobil");
$row_mobil = $mobil_result->fetch_assoc();
$total_mobil = $row_mobil['total_unit'];
?>

<div class="header">
    <h2>Selamat Datang Di Dashboard Admin</h2>
    <select class="admin-dropdown">
        <option>admin01</option>
    </select>
</div>

<div class="dashboard-cards">
    <div class="card">
        <div class="card-title">Total Transaksi</div>
        <div class="card-value"><?php echo $total_transaksi; ?></div>
    </div>
    <div class="card">
        <div class="card-title">Mobil Tersedia</div>
        <div class="card-value"><?php echo $total_mobil; ?></div>
    </div>
    <div class="card">
        <div class="card-title">Sopir Tersedia</div>
        <div class="card-value"><?php echo $total_sopir; ?></div>
    </div>
</div>

<div class="table-container">
    <div class="table-header">
        <div class="table-title">Mobil yang Tersedia</div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mobil</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Toyota Xpander</td>
                <td>1</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Toyota Alphard</td>
                <td>1</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Daihatsu Ayla</td>
                <td>4</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Daihatsu Xenia</td>
                <td>3</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Hyundai Palisade</td>
                <td>1</td>
            </tr>
        </tbody>
    </table>
</div>
</div>