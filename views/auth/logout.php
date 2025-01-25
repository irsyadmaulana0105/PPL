<?php
session_start();
$conn = new mysqli("localhost:3306", "root", "", "pecos_menu");
$id_user = $_SESSION["id_meja"];
$select_sql = "SELECT id_menu, stock FROM cart_items WHERE id_user = ?";
$stmt = $conn->prepare($select_sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$stmt->bind_result($id_menu, $stock);
$result = [];

// Iterasi melalui hasil set
while ($stmt->fetch()) {
    // Menyimpan setiap baris hasil ke dalam array
    $result[] = [
        'id_menu' => $id_menu,
        'stock' => $stock
    ];
}

// Tutup pernyataan setelah selesai menggunakan hasil set
$stmt->close();
foreach ($result as $item) {
    // Menyediakan dan menjalankan pernyataan UPDATE untuk mengemaskini stok
    $update_sql = "UPDATE menu_items SET stock = stock + ? WHERE id = ?";
    $stmt_update = $conn->prepare($update_sql);
    $stmt_update->bind_param("ii", $item['stock'], $item['id_menu']);
    $stmt_update->execute();
    $stmt_update->close();
}

$delete_sql = "DELETE FROM cart_items WHERE id_user = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("i", $id_user );
$stmt->execute();


session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
