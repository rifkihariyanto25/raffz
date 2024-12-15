<?php

namespace Midtrans;

// Load required files
require_once __DIR__ . '/../../admin/config/config.php';
require_once __DIR__ . '/../../admin/config/status_constants.php';
require_once dirname(__FILE__) . '/../Midtrans.php';

// Konfigurasi Midtrans
Config::$isProduction = false; // Ubah ke true untuk produksi
Config::$serverKey = 'SB-Mid-server-dvOaJBd7FgZMQus1K7EutjPN'; // Ganti dengan server key Anda

// File untuk logging
$logFile = dirname(__FILE__) . '/notification.log';

// Fungsi untuk menulis log
function writeLog($message)
{
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

try {
    $notification = new Notification();

    // Mendapatkan data respon notifikasi dari Midtrans
    /** @var \stdClass $response */
    $response = $notification->getResponse();
    writeLog("Raw response: " . json_encode($response));

    // Memeriksa format respons
    if (!is_object($response)) {
        throw new \Exception('Invalid notification response format');
    }

    // Mengambil data dari response dan mengecek properti yang ada
    $transaction = property_exists($response, 'transaction_status') ? $response->transaction_status : '';
    $type = property_exists($response, 'payment_type') ? $response->payment_type : '';
    $order_id = property_exists($response, 'order_id') ? $response->order_id : '';
    $fraud = property_exists($response, 'fraud_status') ? $response->fraud_status : '';
    $gross_amount = property_exists($response, 'gross_amount') ? $response->gross_amount : 0;

    writeLog("Processing notification - Order ID: $order_id, Status: $transaction");

    // Validasi data yang diperlukan
    if (empty($order_id) || empty($transaction)) {
        throw new \Exception('Missing required notification fields');
    }

    // Tentukan status berdasarkan transaction_status
    $status = '';
    switch ($transaction) {
        case 'capture':
            $status = ($type == 'credit_card' && $fraud == 'challenge') ? STATUS_CHALLENGE : STATUS_SUCCESS;
            break;
        case 'settlement':
            $status = STATUS_SETTLEMENT;
            break;
        case 'pending':
            $status = STATUS_PENDING;
            break;
        case 'deny':
            $status = STATUS_DENIED;
            break;
        case 'expire':
            $status = STATUS_EXPIRED;
            break;
        case 'cancel':
            $status = STATUS_CANCELLED;
            break;
        default:
            $status = STATUS_PENDING;
    }

    // Update database dengan status yang diterima
    if (!empty($status) && !empty($order_id)) {
        $sql = "UPDATE bookings SET status_konfirmasi = ? WHERE order_id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $conn->error);
        }

        $stmt->bind_param("ss", $status, $order_id);

        if ($stmt->execute()) {
            writeLog("Status updated successfully for order $order_id to $status");
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => "Status updated successfully"]);
        } else {
            throw new \Exception("Failed to update status: " . $stmt->error);
        }

        $stmt->close();
    } else {
        throw new \Exception("Invalid status or order_id received");
    }
} catch (\Exception $e) {
    // Menangani error dan mencatat log
    writeLog("Error processing notification: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    // Menutup koneksi database jika ada
    if (isset($conn)) {
        $conn->close();
    }
}
