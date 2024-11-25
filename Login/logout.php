<?php
session_start();

require_once 'vendor/autoload.php';
$access_token = $_SESSION['acces_token'];

// inisiasi google client
$client = new Google_Client();

$client->revokeToken();
session_destroy();
header('location: login.php');
