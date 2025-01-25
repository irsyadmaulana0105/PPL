<?php
require_once '/../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image'];

    // Validate and upload image
    if ($image['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../../uploads/";
        $targetFile = $targetDir . basename($image['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Check if file is an image
        $check = getimagesize($image['tmp_name']);
        if ($check !== false) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                // Insert the data into the database
                $stmt = $conn->prepare("INSERT INTO menu_items (name, category, price, stock, image_path) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdis", $name, $category, $price, $stock, $targetFile);

                if ($stmt->execute()) {
                    echo 'Menu item created successfully.';
                } else {
                    echo 'Database error: ' . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            } else {
                echo 'Failed to upload image.';
            }
        } else {
            echo 'File is not an image.';
        }
    } else {
        echo 'Error uploading file: ' . $image['error'];
    }
} else {
    echo 'Invalid request method.';
}
?>
