<?php
require_once '../config/config.php';

$booking_result = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");

// Define status constants if not already defined
defined('STATUS_CHALLENGE') or define('STATUS_CHALLENGE', 'Challenge by FDS');
defined('STATUS_SUCCESS') or define('STATUS_SUCCESS', 'Success');
defined('STATUS_SETTLEMENT') or define('STATUS_SETTLEMENT', 'Settlement');
defined('STATUS_PENDING') or define('STATUS_PENDING', 'Pending');
defined('STATUS_DENIED') or define('STATUS_DENIED', 'Denied');
defined('STATUS_EXPIRED') or define('STATUS_EXPIRED', 'Expired');
defined('STATUS_CANCELLED') or define('STATUS_CANCELLED', 'Cancelled');

// Fungsi hapus booking
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_booking']) && isset($_POST['hapus'])) {
    $booking_id = intval($_POST['id_booking']);

    $sql = "DELETE FROM bookings WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('i', $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Pesanan berhasil dihapus!'); window.location.href='index.php#bookingPage';</script>";
        exit;
    } else {
        echo "Gagal menghapus data: " . $stmt->error;
    }

    $stmt->close();
}

?>

<style>
    .status {
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        display: inline-block;
    }

    .status.pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status.success,
    .status.settlement {
        background-color: #d4edda;
        color: #155724;
    }

    .status.denied {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status.expired {
        background-color: #e2e3e5;
        color: #383d41;
    }

    .status.cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status.challenge {
        background-color: #fff3cd;
        color: #856404;
    }

    .btn-view,
    .btn-delete {
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 0 2px;
    }

    .btn-view:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
    }
</style>

<div class="table-container">
    <div class="table-header">
        <div class="table-title">Data Booking</div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Nama Lengkap</th>
                <th>Alamat</th>
                <th>No. WhatsApp</th>
                <th>Mobil</th>
                <th>Total Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
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
                        <td><?= htmlspecialchars($booking['order_id']) ?></td>
                        <td><?= htmlspecialchars($booking['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($booking['pickup_location']) ?></td>
                        <td><?= htmlspecialchars($booking['whatsapp']) ?></td>
                        <td><?= htmlspecialchars($booking['driver_option']) ?></td>
                        <td>Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $status = $booking['status_konfirmasi'];

                            switch ($status) {
                                case STATUS_PENDING:
                                case null:
                                case '':
                                    echo '<span class="status pending">Menunggu Pembayaran</span>';
                                    break;
                                case STATUS_SETTLEMENT:
                                    echo '<span class="status settlement">Pembayaran Berhasil</span>';
                                    break;
                                case STATUS_SUCCESS:
                                    echo '<span class="status success">Pembayaran Sukses</span>';
                                    break;
                                case STATUS_DENIED:
                                    echo '<span class="status denied">Pembayaran Ditolak</span>';
                                    break;
                                case STATUS_EXPIRED:
                                    echo '<span class="status expired">Pembayaran Kadaluarsa</span>';
                                    break;
                                case STATUS_CANCELLED:
                                    echo '<span class="status cancelled">Dibatalkan</span>';
                                    break;
                                case STATUS_CHALLENGE:
                                    echo '<span class="status challenge">Pembayaran Dalam Pengecekan</span>';
                                    break;
                                default:
                                    echo '<span class="status pending">Menunggu Pembayaran</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn-view" data-id="<?= $mobil['id_mobil'] ?>">
                                <i class="fas fa-eye"></i>
                            </button>

                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_booking" value="<?= $booking['booking_id'] ?>">
                                <button type="submit" name="hapus" class="btn-delete"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
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
                    <td colspan="9">Belum ada data booking.</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add auto-refresh script -->
<script>
    // Refresh the page every 30 seconds to check for new notifications
    setInterval(function() {
        location.reload();
    }, 30000);
</script>