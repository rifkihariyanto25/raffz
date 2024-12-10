<?php

namespace Midtrans;

include '../../../admin/config/config.php';
require_once dirname(__FILE__) . '/../../Midtrans.php';

// Set Your server key
Config::$serverKey = 'SB-Mid-server-dvOaJBd7FgZMQus1K7EutjPN';
Config::$clientKey = 'SB-Mid-client-oyLsocrltTJE_7W9';

// Uncomment for production environment
// Config::$isProduction = true;
Config::$isSanitized = Config::$is3ds = true;

$order_id = isset($_GET['id_booking']) ? $_GET['id_booking'] : null;

if (!$order_id) {
    die("ID booking tidak ditemukan.");
}

// Query data booking dari database
$query = "SELECT * FROM bookings WHERE order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$booking_data = $result->fetch_assoc();

if (!$booking_data) {
    die("Data booking tidak ditemukan.");
}

// Required
$transaction_details = array(
    'order_id' => $order_id,
    'gross_amount' => $booking_data['total_price'], // Nilai dari kolom total_price
);

// Optional
$item_details = array(
    array(
        'id' => 'rental',
        'price' => $booking_data['total_price'],
        'quantity' => 1,
        'name' => "Rental Mobil - " . $booking_data['driver_option'],
    ),
);

// Optional
$customer_details = array(
    'first_name'    => explode(' ', $booking_data['nama_lengkap'])[0],
    'last_name'     => explode(' ', $booking_data['nama_lengkap'], 2)[1] ?? '',
    'email'         => $booking_data['email'],
    'phone'         => $booking_data['whatsapp'],
);

// Fill transaction details
$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

// Generate snap token
$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
} catch (\Exception $e) {
    echo $e->getMessage();
    die();
}
echo "snapToken = " . $snap_token;

?>

<!DOCTYPE html>
<html>

<body>
    <button id="pay-button">Pay!</button>
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey; ?>"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('<?php echo $snap_token ?>');
        };
    </script>
</body>

</html>