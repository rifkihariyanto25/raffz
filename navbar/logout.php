<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Kembalikan respons sukses
http_response_code(200);
echo json_encode(['status' => 'success']);
