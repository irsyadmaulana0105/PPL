<?php
class MenuItem{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllItems($category = null) {
        $sql = "SELECT id, name, image, stock, price FROM menu_items";
        if ($category) {
            $sql .= " WHERE category = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $category);
        } else {
            $stmt = $this->conn->prepare($sql);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    // public function getCart($id_user, $id_menu) {
    public function getCart($id_user) {
        $sql = "DELETE FROM cart_items WHERE stock = 0";
        $this->conn->query($sql);
        $sql = "SELECT * FROM cart_items WHERE id_user = '$id_user'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function Cart($id_menu, $action, $id_user) {
        $conn = new mysqli("localhost:3306", "root", "", "pecos_menu");
        if ($id_user){
            if($action == "tambah"){
                $check_sql = "SELECT * FROM cart_items WHERE id_user = ? AND id_menu = ?";
                $stmt = $conn->prepare($check_sql);
                $stmt -> bind_param("ii", $id_user, $id_menu);
                $stmt->execute();
                $result = $stmt->get_result();
                if (mysqli_num_rows($result) > 0) {
                    $update_sql = "UPDATE cart_items SET stock = stock + 1, total = price * stock  WHERE id_user = '$id_user' AND id_menu = '$id_menu'";
                    mysqli_query($conn, $update_sql);
                } else {
                    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE id = ?");
                    $stmt->bind_param("i", $id_menu);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $name = $row['name'];
                    $category= $row['category'];
                    $price= $row['price'];
                    $insert_sql = "INSERT INTO cart_items (id_user, id_menu, nama, category, price, total,  stock) VALUES ('$id_user', '$id_menu','$name','$category','$price','$price', 1)"; // benerin dah
                    mysqli_query($conn, $insert_sql);
                }
                $sql = "UPDATE menu_items SET stock = stock - 1 WHERE id = '$id_menu'";
                mysqli_query($conn, $sql);
            } else if ($action == "kurang"){
                $update_sql = "UPDATE cart_items SET stock = stock - 1, total = price * stock WHERE id_user = '$id_user' AND id_menu = '$id_menu'";
                mysqli_query($conn, $update_sql);
                $sql = "UPDATE menu_items SET stock = stock + 1 WHERE id = '$id_menu'";
                mysqli_query($conn, $sql);
            }
    
            $sql = "SELECT * FROM cart_items WHERE id_user = '$id_user'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $items = [];
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($items);
    
    
            mysqli_close($conn);
        } else {
            // Fetch all items for the user to update stock in menu_items table
            $select_sql = "SELECT id_menu, stock FROM cart_items WHERE id_user = ?";
            $stmt = $conn->prepare($select_sql);
            $stmt->bind_param("i", $id_user);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $id_menu = $row['id_menu'];
                $stock = $row['stock'];

                // Update the stock in menu_items table
                $update_stock_sql = "UPDATE menu_items SET stock = stock + ? WHERE id = ?";
                $stmt_update = $conn->prepare($update_stock_sql);
                $stmt_update->bind_param("ii", $stock, $id_menu);
                $stmt_update->execute();
            }

            // Delete all items from the cart for the user
            $delete_sql = "DELETE FROM cart_items WHERE id_user = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $id_user);
            $stmt->execute();

            // No need to fetch results after delete, as the cart should be empty
            $items = [];
            header('Content-Type: application/json');
            echo json_encode($items);

            $stmt->close();
            $conn->close();
        }

    }
    
    
    public function updateStock($id, $action) {
        if ($action === 'decrease') {
            $stmt = $this->conn->prepare("UPDATE menu_items SET stock = stock - 1 WHERE id = ? AND stock > 0");
        } elseif ($action === 'increase') {
            $stmt = $this->conn->prepare("UPDATE menu_items SET stock = stock + 1 WHERE id = ?");
        } elseif ($action === 'order') {
            $stmt = $this->conn->prepare("UPDATE menu_items SET stock = stock - 1 WHERE id = ? AND stock > 0");
        } elseif ($action === 'delete') {
            $stmt = $this->conn->prepare("UPDATE menu_items SET stock = stock + 1 WHERE id = ?");
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function deletestock($id_menu) {
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->bind_param("i", $id_menu);
        return $stmt->execute();
    }
    
    
    
}
?>
