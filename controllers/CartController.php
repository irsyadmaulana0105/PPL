<?php
include 'models/MenuItem.php';

class CartController {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function index() {
        $menuItem = new MenuItem($this->conn);
        $allItems = $menuItem->getAllItems();
        include 'views/cart.php';
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $action = $_POST['action'];

            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = 0;
            }
            $_SESSION['cart'][$id]++;

            $menuItem = new MenuItem($this->conn);
            if ($menuItem->updateStock($id, 'order')) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => "Unable to add to cart."]);
            }
        }
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $action = $_POST['action'];

            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]--;
                if ($_SESSION['cart'][$id] == 0) {
                    unset($_SESSION['cart'][$id]);
                }
            }

            $menuItem = new MenuItem($this->conn);
            if ($menuItem->updateStock($id, 'delete')) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => "Unable to remove from cart."]);
            }
        }
    }
}
?>
