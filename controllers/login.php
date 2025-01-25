<?php
session_start();
require_once __DIR__ . '/../models/AuthModels.php';
require_once __DIR__ . '/../db_connection.php';

if (isset($_POST['qr-code']) && !empty($_POST['qr-code'])) {
    $qrCode = $_POST['qr-code'];
    $auth = new Auth($conn);
    $role = $auth->log($qrCode);

    if ($role !== null) {
        $_SESSION['role'] = $role;
        
        // Set a cookie with the role
        setcookie("id_menu", $role, time() + (86400 * 30), "/"); // 86400 = 1 day, the cookie will last for 30 days

        if ($role === 'user') {
            header("Location: /mvcpecos/");
        } elseif ($role === 'employee') {
            header("Location: /mvcpecos/views/pegawai/index.php");
        }
        exit();
    } else {
        $_SESSION['gagal'] = "gagal";
        header("Location: http://localhost/mvcpecos/views/auth/login.php");
    }
} else {
    echo "No QR code detected.";
}
?>
