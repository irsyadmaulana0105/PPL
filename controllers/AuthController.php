<?php

session_start();

include '../models/AuthModels.php';
require_once "../db_connection.php";

class AuthController {
    private $auth;

    public function __construct($conn) {
        $this->auth = new Auth($conn);
    }

    public function login() {
        if (isset($_SESSION['id_meja'])) {
            $this->redirectBasedOnRole($_SESSION['role']);
        } else {
            include 'views/auth/login.php';
        }
    }

    public function processQRCode($qr_content) {
        $role = $this->auth->log($qr_content);
        if ($role !== null) {
            $this->redirectBasedOnRole($role);
        } else {
            echo "Gagal login"; // Atau lakukan penanganan yang sesuai dengan kegagalan login
        }
    }

    private function redirectBasedOnRole($role) {
        if ($role === 'user') {
            header("Location: /mvcpecos/");
            exit();
        } elseif ($role === 'employee') {
            header("Location: /mvcpecos/views/pegawai/index.php");
            exit();
        } else {
            echo "Peran tidak valid.";
        }
    }
}

// Cek jika ada input code dari form
if (isset($_POST["code"]) && !empty($_POST["code"])) {
    $auth = new AuthController($conn); 
    $auth->processQRCode($_POST["code"]);
} else {
    $auth = new AuthController($conn); 
    $auth->login();
}
?>
