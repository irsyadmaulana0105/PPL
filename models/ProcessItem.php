<?php
class ProcessItem {
    private $conn;
    private $table_name = "process_items";

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
}
?>
