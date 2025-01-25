<?php
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../models/HistoryItem.php'; // Tambahkan ini untuk mengimpor HistoryItem
require_once __DIR__ . '/../db_connection.php'; // Pastikan untuk mengimpor koneksi database
session_start();
$menuModel = new MenuModel($conn);
$historyItemModel = new HistoryItem($conn);

if (isset($_POST['action'])) {
    if (isset($_SESSION['id_meja'])) {
        $id_user = $_SESSION['id_meja'];
        $conn = new mysqli("localhost:3306", "root", "", "pecos_menu");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->begin_transaction();

        try {
            $update_sql = "UPDATE menu_item m
                           JOIN process_items p ON m.id_menu = p.id_menu
                           SET m.stock = m.stock + p.stock
                           WHERE p.id_user = ? AND p.stock != 0";
            $stmt_update = $conn->prepare($update_sql);
            if (!$stmt_update) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt_update->bind_param("i", $id_user);
            if (!$stmt_update->execute()) {
                throw new Exception("Execute failed: " . $stmt_update->error);
            }

            $delete_sql = "DELETE FROM process_items WHERE id_user = ?";
            $stmt_delete = $conn->prepare($delete_sql);
            if (!$stmt_delete) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt_delete->bind_param("i", $id_user);
            if (!$stmt_delete->execute()) {
                throw new Exception("Execute failed: " . $stmt_delete->error);
            }

            $conn->commit();

            echo "Stock berhasil dikembalikan dan process_items dihapus.";
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }

        $stmt_update->close();
        $stmt_delete->close();
        $conn->close();
    } else {
        echo "id_meja tidak tersedia di sesi.";
    }
}
?>
