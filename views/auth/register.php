<?php
session_start();
require_once '../../db_connection.php';
require_once '../../models/HistoryItem.php';

// Inisialisasi variabel $sold_items
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

        .profile-info p {
            margin: 0;
        }

        .profile-info a {
            text-decoration: none;
            color: #333;
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

        .registration-form {
            background: #FFF;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 50%;
            margin: 0 auto;
        }

        .registration-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .registration-form p {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #00976d;
            color: #FFF;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #007B59;
        }

        .qr-code-container {
            display: none;
            text-align: center;
        }

        .qr-code-container img {
            max-width: 100%;
        }
    </style>
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
                    <li class="active"><a href="../auth/register.php">Create QR</a></li>
                    <li><a href="../pegawai/view.php">View</a></li>
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
            <div class="registration-form" id="registrationForm">
                <h2 class="text-center">Registration Form</h2>
                <p class="text-center">Fill in your personal details.</p>
                <form action="../../models/add-user.php" method="POST">
                    <div class="hide-registration-inputs">
                        <div class="form-group registration">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group registration">
                            <label for="role">Role:</label>
                            <select class="form-control" id="role" name="role">
                                <option value="user">User</option>
                                <option value="employee">Employee</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-dark login-register form-control" onclick="generateQrCode()">Register and Generate QR Code</button>
                    </div>

                    <div class="qr-code-container text-center" id="qrCodeContainer">
                        <input type="hidden" id="generatedCode" name="generated_code">
                        <div class="m-4" id="qrBox">
                            <img src="" id="qrImg">
                        </div>
                        <button type="submit" class="btn btn-dark">Back</button>
                    </div>
                </form>
            </div>
            </main>
        </div>
    </div>
</body>
</html>



<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<!-- instascan Js -->
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    const loginCon = document.querySelector('.login-container');
    const registrationCon = document.querySelector('.registration-container');
    const registrationForm = document.querySelector('.registration-form');
    const qrCodeContainer = document.querySelector('.qr-code-container');
    let scanner;

    registrationCon.style.display = "none";
    qrCodeContainer.style.display = "none";

    function showRegistrationForm() {
        registrationCon.style.display = "";
        loginCon.style.display = "none";
        scanner.stop();
    }

    function startScanner() {
    scanner = new Instascan.Scanner({ video: document.getElementById('interactive') });

    scanner.addListener('scan', function (content) {

        $.ajax({
            type: "POST",
            url: "/mvcpecos/controllers/AuthController.php",
            data: { code: content },
            success: function(response) {
            console.log(response);
            if (response.trim() === "user") {
                $("#loginForm").attr("action", "/mvcpecos/"); // Atur action ke menu user
            } else if (response.trim() === "employee") { 
                $("#loginForm").attr("action", "/mvcpecos/views/pegawai/index.php"); // Atur action ke index pegawai
            }
        }

        });

        scanner.stop();
        $(".qr-detected-container").css("display", "block");
        $(".viewport").css("display", "none");
    });



        Instascan.Camera.getCameras()
            .then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                    alert('No cameras found.');
                }
            })
            .catch(function (err) {
                console.error('Camera access error:', err);
                alert('Camera access error: ' + err);
            });
    }

    function generateRandomCode(length) {
        const characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        let randomString = '';

        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            randomString += characters.charAt(randomIndex);
        }

        return randomString;
    }

    function generateQrCode() {
            const name = document.getElementById('name').value;
            const role = document.getElementById('role').value;

            if (name && role) {
                const qrCodeData = `${name}-${role}`;
                const qrImg = document.getElementById('qrImg');
                qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(qrCodeData)}&size=150x150`;

                document.getElementById('generatedCode').value = qrCodeData;
                document.querySelector('.hide-registration-inputs').style.display = 'none';
                document.getElementById('qrCodeContainer').style.display = 'block';
            } else {
                alert('Please fill in all fields');
            }
        }

    document.addEventListener('DOMContentLoaded', startScanner);
</script>