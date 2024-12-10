<?php

namespace Midtrans;

require_once dirname(__FILE__) . '/../Midtrans.php';

Config::$isProduction = false;
Config::$serverKey = 'SB-Mid-server-dvOaJBd7FgZMQus1K7EutjPN';

printExampleWarningMessage();

try {
    $notif = new Notification();
} catch (\Exception $e) {
    logError($e->getMessage());
    exit("Error: " . $e->getMessage());
}

$notifResponse = $notif->getResponse();

if (is_object($notifResponse)) {
    $transaction = $notifResponse->transaction_status;
    $type = $notifResponse->payment_type;
    $order_id = $notifResponse->order_id;
    $fraud = $notifResponse->fraud_status;
} else {
    logError("Invalid response format from Midtrans.");
    exit("Invalid response format.");
}

include '../../../admin/config/config.php';

$stmt = $conn->prepare("UPDATE bookings SET status_konfirmasi = ? WHERE order_id = ?");

$status = getTransactionStatus($transaction, $type, $fraud);

$stmt->bind_param("ss", $status, $order_id);
if ($stmt->execute()) {
    echo "Payment status for order_id: " . $order_id . " updated to: " . $status;
} else {
    logError("Failed to update payment status for order_id: " . $order_id);
    echo "Failed to update payment status.";
}

$stmt->close();
$conn->close();

function getTransactionStatus($transaction, $type, $fraud)
{
    if ($transaction == 'capture') {
        if ($type == 'credit_card') {
            return ($fraud == 'challenge') ? 'Challenge by FDS' : 'Success';
        }
    } else if ($transaction == 'settlement') {
        return 'Settlement';
    } else if ($transaction == 'pending') {
        return 'Pending';
    } else if ($transaction == 'deny') {
        return 'Denied';
    } else if ($transaction == 'expire') {
        return 'Expired';
    } else if ($transaction == 'cancel') {
        return 'Cancelled';
    }
    return 'Unknown';
}

function logError($message)
{
    $logFile = dirname(__FILE__) . '/notification-error.log';
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

function printExampleWarningMessage()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo 'Notification-handler are not meant to be opened via browser / GET HTTP method. It is used to handle Midtrans HTTP POST notification / webhook.';
        exit;
    }
    if (strpos(Config::$serverKey, 'SB-Mid-server-dvOaJBd7FgZMQus1K7EutjPN') !== false) {
        echo "<code>";
        echo "<h4>key</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = SB-Mid-server-dvOaJBd7FgZMQus1K7EutjPN;');
        die();
    }
}
