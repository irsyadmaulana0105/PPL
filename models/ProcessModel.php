<?php

class ProcessModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getItemsByCategory($category) {
        $sql = "SELECT id, name, image FROM cart_items WHERE category = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getCartItems() {
        $sql = "SELECT id_menu, id_user, stock FROM process";
        $result = $this->conn->query($sql);
        return ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getItemById($id) {
        $sql = "SELECT id, name, price FROM cart_items WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result) ? $result->fetch_assoc() : null;
    }
}
?>
