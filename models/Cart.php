<?php
class Cart {
    private $conn;
    private $table_name = "cart_items";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getItemsByUser($id_user) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare statement failed: " . $this->conn->error);
        }
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function moveItemsToHistory($id_user) {
        // Fetch items from cart
        $cartItems = $this->getItemsByUser($id_user);

        // Begin transaction (optional but recommended for data integrity)
        $this->conn->begin_transaction();
        try {
            // Insert items into history
            $query = "INSERT INTO history (id_user, id_menu, nama, price, total, stock) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            foreach ($cartItems as $item) {
                $stmt->bind_param('iisiii', $item['id_user'], $item['id_menu'], $item['nama'], $item['price'], $item['total'], $item['stock']);
                if (!$stmt->execute()) {
                    throw new Exception("Execute statement failed: " . $stmt->error);
                }
            }

            // Clear items from cart
            $query = "DELETE FROM " . $this->table_name . " WHERE id_user = ?";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }
            $stmt->bind_param('i', $id_user);
            if (!$stmt->execute()) {
                throw new Exception("Execute statement failed: " . $stmt->error);
            }

            // Commit transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->conn->rollback();
            throw new Exception("Transaction failed: " . $e->getMessage());
        }
    }
}
?>
