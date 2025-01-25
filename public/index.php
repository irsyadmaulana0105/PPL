<?php
// Start the session
session_start();

// Include the necessary files
include '../db_connection.php';
include '../models/UserModel.php';
include '../controllers/Login.php';

$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/public', '', $request); // Adjust the request URI if the 'public' folder is in the URL

switch ($request) {
    case '/':
    case '/login':
        $db = new mysqli('host', 'user', 'password', 'database'); // Update with your database credentials
        $userModel = new UserModel($db);
        $controller = new LoginController($userModel);
        $controller->login();
        break;
    case '/logout':
        // Implement the logout functionality
        session_destroy();
        header("Location: login.php");
        break;
    // Add more routes here as needed
    default:
        http_response_code(404);
        echo "Page not found";
        break;
}
?>
