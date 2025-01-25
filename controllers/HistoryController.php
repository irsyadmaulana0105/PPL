<?php
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../models/HistoryItem.php'; // Tambahkan ini untuk mengimpor HistoryItem
require_once __DIR__ . '/../db_connection.php'; // Pastikan untuk mengimpor koneksi database
// session_start();     
$menuModel = new MenuModel($conn);
$historyItemModel = new HistoryItem($conn);

if (isset($_POST['action'])) {
    if (isset($_SESSION['id_meja'])) {
        $id_user = $_SESSION['id_meja'];
        $conn = new mysqli("localhost:3306", "root", "", "pecos_menu");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $insert_sql = "INSERT INTO history_item (id_user, id_menu, nama, category, price, total, stock)
                       SELECT id_user, id_menu, nama, category, price, total, stock
                       FROM process_items WHERE id_user = ? AND stock != 0";
        $stmt_insert = $conn->prepare($insert_sql);
        $stmt_insert->bind_param("i", $id_user);
        $stmt_insert->execute();

        $delete_sql = "DELETE FROM process_items WHERE id_user = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("i", $id_user);
        $stmt_delete->execute();

        $stmt_insert->close();
        $stmt_delete->close();
        $conn->close();
    } else {
        echo "id_meja tidak tersedia di sesi.";
    }
}
?>
