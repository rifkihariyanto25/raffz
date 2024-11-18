<?php

$booking_result = $conn->query("SELECT * FROM bookings");
// Fungsi konfirmasi booking
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


// Fungsi hapus booking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_booking']) && isset($_POST['hapus'])) {
    $booking_id = intval($_POST['id_booking']);

    // Query untuk menghapus data booking
    $sql = "DELETE FROM bookings WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('i', $booking_id);

    if ($stmt->execute()) {
        header("Location: manage_mobil.php#bookingPage");
        exit;
    } else {
        echo "Gagal menghapus data: " . $stmt->error;
    }

    $stmt->close();
}

?>


<div class="header">
    <h2>Data Booking</h2>
    <select class="admin-dropdown">
        <option>admin01</option>
    </select>
</div>

<div class="table-container">
    <div class="table-header">
        <div class="table-title">Data Booking</div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <th>No. WhatsApp</th>
                <th>Mobil</th>
                <th>Status Konfirmasi</th>
                <th>Aksi Konfirmasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($booking_result->num_rows > 0) {
                $nomor = 1;
                while ($booking = $booking_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $nomor++ . "</td>";
                    echo "<td>" . htmlspecialchars($booking['nama_lengkap']) . "</td>";
                    echo "<td>" . htmlspecialchars($booking['pickup_location']) . "</td>";
                    echo "<td>" . htmlspecialchars($booking['whatsapp']) . "</td>";
                    echo "<td>" . htmlspecialchars($booking['driver_option']) . "</td>";
                    echo "<td id='status-" . $booking['booking_id'] . "'>" . ($booking['status_konfirmasi'] == 'Sudah Dikonfirmasi' ? 'Dikonfirmasi' : 'Belum Dikonfirmasi') . "</td>";
                    echo "<td>";

                    // Tombol konfirmasi
                    echo "<form method='POST' action='' style='display:inline;'>";
                    echo "<input type='hidden' name='id_booking' value='" . $booking['booking_id'] . "'>";
                    echo "<button type='submit' name='konfirmasi' class='btn-konfirmasi'>Konfirmasi</button>";
                    echo "</form>";

                    // Form untuk hapus
                    echo "<form method='POST' action='' style='display:inline;' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus pesanan ini?\");'>";
                    echo "<input type='hidden' name='id_booking' value='" . $booking['booking_id'] . "'>";
                    echo "<button type='submit' name='hapus' class='btn-hapus'>Hapus</button>";
                    echo "</form>";

                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Belum ada data booking.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
</body>