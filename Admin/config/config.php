<?php

define('BASE_PATH', dirname(dirname(dirname(__FILE__))));
define('ASSET_PATH', '../../Asset');

$host = "localhost";
$user = "root";
$password = "";
$database = "rental_mobil";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
