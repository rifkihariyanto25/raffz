<?php


// Include Midtrans config and library files
require_once '../config/config.php';
require_once __DIR__ . '/../../midtrans/examples/notification-handler.php';  // Path to the Midtrans library

// Set your Midtrans server key (sandbox or production) in the Config class, not an object
\Midtrans\Config::$serverKey = 'SB-Mid-server-dvOaJBd7FgZMQus1K7EutjPN'; // Replace with your server key
\Midtrans\Config::$clientKey = 'SB-Mid-client-oyLsocrltTJE_7W9'; // Replace with your client key
\Midtrans\Config::$isProduction = false; // Set to true for production environment
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;



// Fetch booking data
$booking_result = $conn->query("SELECT * FROM bookings");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_booking']) && isset($_POST['konfirmasi'])) {
        // Confirm booking
        $booking_id = intval($_POST['id_booking']);
        $sql = "UPDATE bookings SET status_konfirmasi = 'Sudah Dikonfirmasi' WHERE booking_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param('i', $booking_id);

        if ($stmt->execute()) {
            echo "<script>
    alert('Pesanan berhasil dikonfirmasi!');
    window.location.href = 'index.php#bookingPage';
</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    if (isset($_POST['id_booking']) && isset($_POST['hapus'])) {
        // Delete booking
        $booking_id = intval($_POST['id_booking']);

        $sql = "DELETE FROM bookings WHERE booking_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param('i', $booking_id);

        if ($stmt->execute()) {
            echo "<script>
    alert('Pesanan berhasil dihapus!');
    window.location.href = 'index.php#bookingPage';
</script>";
            exit;
        } else {
            echo "Gagal menghapus data: " . $stmt->error;
        }

        $stmt->close();
    }
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
            ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= htmlspecialchars($booking['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($booking['pickup_location']) ?></td>
                        <td><?= htmlspecialchars($booking['whatsapp']) ?></td>
                        <td><?= htmlspecialchars($booking['driver_option']) ?></td>
                        <td>
                            <?= $booking['status_konfirmasi'] == 'Sudah Dikonfirmasi' ? 'Dikonfirmasi' : 'Belum Dikonfirmasi' ?>
                        </td>
                        <td>
                            <!-- Form konfirmasi -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_booking" value="<?= $booking['booking_id'] ?>">
                                <button type="submit" name="konfirmasi" class="btn-view">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>

                            <!-- Form hapus -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_booking" value="<?= $booking['booking_id'] ?>">
                                <button type="submit" name="hapus" class="btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7">Belum ada data booking.</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>