<?php
session_start();

// require_once 'vendor/autoload.php';
// $access_token = $_SESSION['acces_token'];

// $client->revokeToken();
session_destroy();
header('location: ../index.php');
