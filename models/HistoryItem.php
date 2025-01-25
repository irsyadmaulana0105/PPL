<?php
class HistoryItem {
    private $conn;
    private $table_name = "history_item";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getItemsByUser($id_user) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addItem($id_user, $id_menu, $nama, $category, $price, $total) {
        $query = "INSERT INTO " . $this->table_name . " (id_user, id_menu, nama, category, price, total) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('iissdi', $id_user, $id_menu, $nama, $category, $price, $total);
        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
