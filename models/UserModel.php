<?php

class UserModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addUser($name, $generatedCode, $role) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO `user` (`id_meja`, `generated_code`, `role`) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $generatedCode, $role);
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getAllUsers() {
        try {
            $query = "SELECT * FROM `user`";
            $result = $this->conn->query($query);

            if ($result === false) {
                throw new Exception("Query failed: " . $this->conn->error);
            }

            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function deleteUser($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM `user` WHERE id = ?");
            $stmt->bind_param('i', $id);
            return $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
