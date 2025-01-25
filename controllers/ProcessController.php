<?php
require_once __DIR__ . '/../models/ProcessModel.php';
require_once __DIR__ . '/../models/ProcessItem.php'; // Tambahkan ini untuk mengimpor ProcessItem
require_once __DIR__ . '/../db_connection.php'; // Pastikan untuk mengimpor koneksi database
session_start();
$processModel = new ProcessModel($conn);
$ProcessItemModel = new ProcessItem($conn); // Inisialisasi ProcessItem dengan koneksi database


if (isset($_POST['action'])) {
    $id_user = $_SESSION['id_meja'];
    $conn = new mysqli("localhost:3306", "root", "", "pecos_menu");
    $insert_sql = "INSERT INTO process_items (id_user, id_menu, nama, category, price, total, stock)
                   SELECT id_user, id_menu, nama, category, price, total, stock
                   FROM cart_items where id_user = $id_user AND stock != 0";
    $conn->query($insert_sql);

    $delete_sql = "DELETE FROM cart_items WHERE id_user = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id_user );
    $stmt->execute();
}