<?php
session_start();
require_once __DIR__ . '/../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // Assuming the menu item ID is passed through POST

    // Delete the menu item from database
    $sql = "DELETE FROM menu_items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        echo "Menu item deleted successfully!";
    } else {
        echo "Error deleting menu item: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
