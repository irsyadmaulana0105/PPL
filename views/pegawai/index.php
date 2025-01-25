<?php
session_start();
require_once __DIR__ . '/../../db_connection.php';
require_once __DIR__ . '/../../models/HistoryItem.php';

$sold_items = [];

if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'user'){
    header("location: /mvcpecos/pegawai");
}}

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
                                <li class="active"><a href="../pegawai/index.php">Process</a></li>
                                <li><a href="../pegawai/menu.php">Menu</a></li>
                            </ul>
                        </nav>
                    <div class="profile">
                        <div class="profile-info">
                            <p><?php echo htmlspecialchars($_SESSION['role']); ?></p>
                            <a href="../../views/auth/login.php">Logout</a>
                        </div>
                    </div>
                </aside>
            <main class="main-content">
    <header class="header">
        <h1>Proces</h1>
    </header>
    <section class="content">
        <div class="sold-list">
            <?php
            $sql = "SELECT id, id_user, id_menu, nama, category, price, total FROM process_items";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $items_by_user = [];

                while($row = $result->fetch_assoc()) {
                    if ($row["total"] == 0) {
                        continue;
                    }

                    $user_id = $row["id_user"];
                    if (!isset($items_by_user[$user_id])) {
                        $items_by_user[$user_id] = [];
                    }
                    $items_by_user[$user_id][] = $row;
                }

                foreach ($items_by_user as $user_id => $items) {
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<p><strong>Meja:</strong> ' . htmlspecialchars($user_id) . '</p>';

                    foreach ($items as $item) {
                        echo '<div class="card-item">';
                        echo '<p><strong>Nama:</strong> ' . htmlspecialchars($item["nama"]) . '</p>';
                        echo '<p><strong>Category:</strong> ' . htmlspecialchars($item["category"]) . '</p>';
                        echo '<p><strong>Price:</strong> ' . htmlspecialchars($item["price"]) . '</p>';
                        echo '<p><strong>Total:</strong> ' . htmlspecialchars($item["total"]) . '</p>';
                        echo '</div>';
                    }

                    echo '<div class="btn-group">';
                    echo '<button class="btn-confirm" onclick="nextStep()">Konfirmasi</button>';
                    // echo '<button class="btn-cancel" onclick="cancelItem()">Tidak</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                // if ($items[0]["status"] == 'Process') {
                //     echo '<div class="btn-group">';
                //     echo '<button class="btn-confirm" onclick="nextStep(' . htmlspecialchars($user_id) . ')">Konfirmasi</button>';
                //     // echo '<button class="btn-cancel" onclick="cancelItem()">Tidak</button>';
                //     echo '</div>';
                // }

            } else {
                echo "<p>0 results</p>";
            }

            // Tutup koneksi
            $conn->close();
            ?>
        </div>
    </section>

</main>
</div>
</div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
function nextStep() {
    $.ajax({
        type: "POST",
        url: "/mvcpecos/controllers/HistoryController.php",
        data: { action: "nextStep" },
        success: function(response) {
            Swal.fire({
                title: 'Berhasil!',
                icon: 'success',
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(response);
                    window.location.reload();
                }
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Ajax request failed!',
                text: error,
                icon: 'error',
            });
        }
    });
}


function cancelItem() {
    $.ajax({
        type: "POST",
        url: "/mvcpecos/controllers/CancelController.php",
        data: { action: "cancelItem" },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    title: 'Terhapus!',
                    icon: 'info',
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(response);
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: response.message || 'Item tidak dapat dihapus.',
                    icon: 'error',
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Ajax request failed!',
                text: error,
                icon: 'error',
            });
        }
    });
}

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

.btn-confirm {
        padding: 8px 16px;
        margin-left: 10px;
        background-color: #28a745;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
        width: 100px;
    }

    .btn-confirm:hover{
        background-color: #2f865f;
    }
.btn-cancel {
        padding: 8px 16px;
        margin-left: 10px;
        background-color: #e74c3c;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
        width: 100px;
    }

    .btn-cancel:hover{
        background-color: #c0392b;
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
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        margin-bottom: 20px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
    }

    .card p {
        margin: 5px 0;
        line-height: 1.6;
    }

    .card-item {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .card-item:last-child {
        border-bottom: none;
    }

    .card-item p {
        margin: 0;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
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
</style>
