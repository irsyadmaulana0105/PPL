<?php
session_start();
require_once __DIR__ . '/../../db_connection.php';
require_once __DIR__ . '/../../models/HistoryItem.php';

$sold_items = [];

// if(isset($_SESSION['role'])){
//     if($_SESSION['role'] == 'user'){
//     header("location: /mvcpecos/");
// }}

if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $historyItem = new HistoryItem($conn);
    $sold_items = $historyItem->getItemsByUser($id_user);
}
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
                    <ul>
                        <li><a href="../auth/register.php">Create QR</a></li>
                        <li><a href="../pegawai/view.php">View</a></li>
                        <li><a href="../pegawai/history.php">History</a></li>
                        <li><a href="../pegawai/index.php">Process</a></li>
                        <li class="active"><a href="../pegawai/menu.php">Menu</a></li>
                    </ul>
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
        <h1>Menu Items</h1>
        <a href="create_menu_item.php" class="create-menu-item-btn">Create Menu Item</a>
        <a href="delete_menu_item.php" class="create-menu-item-btn">Delete Menu Item</a>
    </header>
    <section class="content">
                    <div class="sold-list">
                        <section class="content">
                            <!-- <h2>Data Table</h2> -->
                            <div class="table-container">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>image</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT id, name, category, price, image, stock FROM menu_items";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>" . htmlspecialchars($row["id"]). "</td>
                                                        <td>" . htmlspecialchars($row["name"]). "</td>
                                                        <td>" . htmlspecialchars($row["category"]). "</td>
                                                        <td>" . htmlspecialchars($row["price"]). "</td>
                                                        <td>" . htmlspecialchars($row["image"]). "</td>
                                                        <td>" . htmlspecialchars($row["stock"]). "</td>
                                                      </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>0 results</td></tr>";
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                    </section>
            </div>
    </section>
</main>

        </div>
    </div>
</body>
</html>



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

.search-bar {
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
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
