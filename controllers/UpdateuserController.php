<?php
session_start();
require_once '../db_connection.php'; // Adjusted file path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['id_meja'], $_POST['role'])) {
        $id = $_POST['id'];
        $id_meja = $_POST['id_meja'];
        $role = $_POST['role'];

        $stmt = $conn->prepare("UPDATE user SET id_meja = ?, role = ? WHERE id = ?");
        if ($stmt === false) {
            die('MySQL prepare error: ' . htmlspecialchars($conn->error));
        }

        // Bind parameters
        $stmt->bind_param("ssi", $id_meja, $role, $id);

        // Execute statement
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
            error_log('Update query failed: ' . $stmt->error);
        }

        // Close statement
        $stmt->close();
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}

$conn->close();
?>
