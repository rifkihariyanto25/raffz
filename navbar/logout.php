<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke homepage setelah logout
header("Location: ../Homepage/homepage.php");
exit();
