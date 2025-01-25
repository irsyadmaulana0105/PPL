<?php
if (isset($_POST['action'])) {
    require_once __DIR__ . '/../models/MenuItem.php';
    $menuController = new MenuController(); 
    if (isset($_POST['id_user'])){
        $menuController->cart(intval($_POST['id_menu']), $_POST['action'], intval($_POST['id_user']));
    } else{
        $menuController->cart(intval($_POST['id_menu']), $_POST['action']);
    }
}else {
    require_once __DIR__ . '/../models/MenuItem.php';
}

class MenuController {
    private $conn;

    public function __construct() {
        // Pastikan $conn diinisialisasi sebelumnya
        global $conn;
        $this->conn = $conn;
    }

    public function index() {
        $menuItem = new MenuItem($this->conn);
        $drinkItems = $menuItem->getAllItems('drink');
        $foodItems = $menuItem->getAllItems('food');
        $snackItems = $menuItem->getAllItems('snack');
        $allItems = $menuItem->getAllItems();
        $cart =  $menuItem->getCart($_SESSION['id_meja']);
        // $cart = isset($_SESSION['id_user']) ? $menuItem->getCart($_SESSION['id_user']) : [];
        include __DIR__ . '/../views/user/menu.php';
    }
        
    public function cart($id_menu, $action, $id_user = null) {
        $menuItem = new MenuItem($this->conn);
        $menuItem->Cart($id_menu, $action, $id_user);
        // include __DIR__ . '/../views/user/cart.php';
    }

    public function updateStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $action = $_POST['action'];

            $menuItem = new MenuItem($this->conn);
            if ($menuItem->updateStock($id, $action)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => "Unable to update stock."]);
            }
        }   
    }
    public function deletestock($id_menu) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $menuItem = new MenuItem($this->conn);
            if ($menuItem->deletestock($id_menu)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "error" => "Unable to delete item from cart."]);
            }
        }
    }
    
    
}
