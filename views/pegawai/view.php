<?php
session_start();
require_once '../../db_connection.php';
require_once '../../models/HistoryItem.php';

$sold_items = [];

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
                    <li class="active"><a href="../pegawai/view.php">View</a></li>
                    <li><a href="../pegawai/history.php">History</a></li>
                    <li><a href="../pegawai/index.php">Process</a></li>
                    <li><a href="../pegawai/menu.php">Menu</a></li>
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
                </header>
                <section class="content">
                    <div class="sold-list">
                        <section class="content">
                            <h2>Data Table</h2>
                            <div class="table-container">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Code</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT id, id_meja, generated_code, role FROM user";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $rowId = $row['id']; // Extract row ID from data
                                                echo "<tr id='row-$rowId'>
        <td>" . htmlspecialchars($row['id']) . "</td>
        <td><input type='text' class='id_meja-input' value='" . htmlspecialchars($row['id_meja']) . "'></td>
        <td>" . htmlspecialchars($row['generated_code']) . "</td>
        <td>
            <select class='role-select'>
                <option value='admin' " . ($row['role'] == 'admin' ? 'selected' : '') . ">Admin</option>
                <option value='user' " . ($row['role'] == 'user' ? 'selected' : '') . ">User</option>
                <option value='employee' " . ($row['role'] == 'employee' ? 'selected' : '') . ">Employee</option>
            </select>
        </td>
        <td><button class='delete-btn' data-id='$rowId'>Delete</button></td>
        <td><button class='update-btn' data-id='$rowId'>Update</button></td>
    </tr>";

                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>0 results</td></tr>";
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
$(document).ready(function() {
        $('.delete-btn').click(function() {
            var rowId = $(this).data('id');
            console.log('Deleting row with ID:', rowId);
            
            $.ajax({
                url: '/mvcpecos/controllers/DeleteuserController.php',
                type: 'POST',
                data: { id: rowId },
                success: function(response) {
                    console.log('Server response:', response);
                if (response.trim() === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    alert('Failed to update the record.');
                    console.error('Failed response from server:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                console.error('Response text:', xhr.responseText);
                alert('Error in the AJAX request.');
            }
        });
    });
});

    $(document).ready(function() {
    $('.update-btn').click(function() {
        var rowId = $(this).data('id');
        var id_meja = $('#row-' + rowId + ' .id_meja-input').val();
        var role = $('#row-' + rowId + ' .role-select').val();

        console.log('Row ID:', rowId);
        console.log('ID Meja:', id_meja);
        console.log('Role:', role);

        $.ajax({
            url: '/mvcpecos/controllers/UpdateuserController.php',
            type: 'POST',
            data: { id: rowId, id_meja: id_meja, role: role },
            success: function(response) {
                console.log('Server response:', response);
                if (response.trim() === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                } else {
                    alert('Failed to update the record.');
                    console.error('Failed response from server:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                console.error('Response text:', xhr.responseText);
                alert('Error in the AJAX request.');
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
        display: flex;
        flex-direction: column;
    }

    .table-container {
        max-height: 400px; /* Set the desired height for the scrollable area */
        overflow-y: auto; /* Enable vertical scrolling */
        background-color: #FFF;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    /* Table styling */
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
