<?php
class SoldItem {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getItemsByUser($id_user) {
        $query = "SELECT id_menu, nama, category, price, total, stock FROM sold_items WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            // Debug: output error
            error_log('Prepare failed: ' . $this->conn->error);
            return [];
        }
        $stmt->bind_param("i", $id_user);
        if (!$stmt->execute()) {
            // Debug: output error
            error_log('Execute failed: ' . $stmt->error);
            return [];
        }
        $result = $stmt->get_result();
        if (!$result) {
            // Debug: output error
            error_log('Get result failed: ' . $stmt->error);
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
