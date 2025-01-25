<?php
session_start();
require_once __DIR__ . '/../db_connection.php';
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct($conn) {
        $this->userModel = new UserModel($conn);
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        include __DIR__ . '/../views/user/menu.php';
    }

    public function add() {
        if (isset($_POST['name']) && isset($_POST['generated_code']) && isset($_POST['role'])) {
            $name = $_POST['name'];
            $generatedCode = $_POST['generated_code'];
            $role = $_POST['role'];
            if ($this->userModel->addUser($name, $generatedCode, $role)) {
                header("Location: /mvcpecos/controllers/UserController.php?action=index");
            } else {
                echo "Error adding user.";
            }
        } else {
            include __DIR__ . '/../views/user/add_akun.php';
        }
    }

    public function delete() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            if ($this->userModel->deleteUser($id)) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "Invalid request";
        }
    }
}

$action = $_GET['action'] ?? 'index';
$controller = new UserController($conn);

if ($action === 'add') {
    $controller->add();
} elseif ($action === 'delete') {
    $controller->delete();
} else {
    $controller->index();
}
?>
