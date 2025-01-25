<?php
session_start();
require_once __DIR__ . '/../../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $targetDir = __DIR__ . '/../../public/img/';
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFilePath)) {
        // Generate a unique file name
        $fileName = $fileName; // Example of generating a unique file name
        $targetFilePath = $targetDir . $fileName;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 1000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = false;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = false;
    }

    // Check if $uploadOk is set to false by an error
    if ($uploadOk === false) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Attempt to move uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            echo "The file ". $fileName. " has been uploaded successfully.";

            // Insert data into database with image path
            $sql = "INSERT INTO menu_items (name, category, price, stock, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssss", $name, $category, $price, $stock, $targetFilePath);
                $stmt->execute();

                if ($stmt->affected_rows === 1) {
                    echo "Menu item created successfully!";
                } else {
                    echo "Error creating menu item: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../../styles.css">
</head>
<body>
  <div class="rectangle2">
    <div class="container">
      <aside class="sidebar">
        <div class="logo">
          <h2>MY PECOS</h2>
        </div> 
        <nav class="menu">

        </nav>
        <div class="profile">
          <div class="profile-info">
            <!-- <p><?php echo htmlspecialchars($_SESSION['role']); ?></p> -->
            <a href="../../views/auth/login.php">Logout</a>
          </div>
        </div>
      </aside>
      <main class="main-content">
        <header class="header">
          <h1>Create Menu Item</h1>
          <a href="menu.php" class="create-menu-item-btn">Back</a>
        </header>
        <section class="content">
          <form action="create_menu_item.php" method="post" enctype="multipart/form-data">  <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
              <label for="category">Category:</label>
              <select name="category" id="category" required>
                <option value="">Select Category</option>
                <option value="food">Food</option>
                <option value="drink">Drink</option>
                <option value="drink">Snack</option>
                </select>
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" name="price" id="price" min="0" required>
            </div>
            <div class="form-group">
              <label for="image">Image:</label>
              <input type="file" name="image" id="image" accept="image/*">
            </div>
            <div class="form-group">
              <label for="stock">Stock:</label>
              <input type="number" name="stock" id="stock" min="0" required>
            </div>
            <button type="submit">Create Menu Item</button>
          </form>
        </section>
      </main>
    </div>
  </div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
   $(document).ready(function() {
    $("#createMenuItemForm").submit(function(event) {
      event.preventDefault(); // Prevent default form submission

      // Get form data
      var formData = new FormData(this);

      $.ajax({
        url: "/mvcpecos/controllers/CreateController.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error("Error submitting form:", textStatus, errorThrown);
          alert("Failed to create menu item. Please check the console for details.");
        }
      });
    });
  });
  </script>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #F0F4F8;
}

.rectangle2 {
    position: absolute;
    width: 90%; 
    height: 80%; 
    left: 5%; 
    top: 10%;
    background: linear-gradient(90deg, rgba(255, 255, 255, 0.44) 38.4%, rgba(103, 177, 157, 0.308706) 75.16%, rgba(0, 124, 90, 0.22) 100%);
    box-shadow: 0px 4px 140px -48px #007B59;
    overflow: hidden;
}

.container {
    display: flex;
    height: 100%;
}

.sidebar {
    width: 20%;
    background-color: #FFFFFF;
    border-right: 1px solid #E0E0E0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px;
}

.logo h2 {
    color: #00976d;
}

.menu ul {
    list-style-type: none;
    padding: 0;
}

.menu ul li {
    margin: 20px 0;
}

.menu ul li a {
    text-decoration: none;
    color: #333;
}

.menu ul li.active a {
    font-weight: bold;
    color: #00976d;
}

.profile {
    display: flex;
    align-items: center;
}

.profile-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.profile-info p {
    margin: 0;
}

.main-content {
    width: 80%;
    padding: 20px;
    background-color: #E9E8E4;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 {
    margin: 0;
}

.form-group {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }
    .form-group label {
      width: 120px;
      margin-right: 10px;
    }
    .form-group input,
    .form-group select {
      padding: 5px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      width: 250px;
    }

    
.content {
    margin-top: 20px;
}

.filter {
    margin-bottom: 20px;
}

.sold-list {
    display: row;
    justify-content: flex-start;
    align-items: center;
    flex-wrap: nowrap;
    max-height: 500px;
    overflow-x: auto;
    padding-bottom: 120px;
    width: 100%;
    margin: 0 auto;;
}

.sold-list::-webkit-scrollbar {
    display: none;
}

.sold-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #FFF;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.card {
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 90%;
    margin-bottom: 12px;
    overflow: hidden;
}

.card-body {    
    display: flex;
    flex-direction: column;
    }

.card-body p {
    margin: 5px 0;
    }

/* Card title */
.card-title {
    font-size: 1.25rem;
}

/* Card text */
.card-text {
    margin-bottom: 0px;
}

/* Delete button */
.delete-button {
    background-color: #e74c3c;
    color: #fff;
    border: none;
    padding: 10px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

/* Delete button hover effect */
.delete-button:hover {
    background-color: #c0392b;
}
table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>
