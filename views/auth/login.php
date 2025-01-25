<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System with QR Code Scanner</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #DEEFE9;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }

        .rectangle2 {
            position: absolute;
            width: 90%; 
            height: 80%; 
            left: 5%; 
            top: 10%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.44) 38.4%, rgba(103, 177, 157, 0.308706) 75.16%, rgba(0, 124, 90, 0.22) 100%);
            box-shadow: 0px 4px 140px -48px #007B59;
        }

        .login-container {
            backdrop-filter: blur(120px);
            color: rgb(255, 255, 255);
            padding: 25px 40px;
            width: 500px;
            border: 2px solid;
            border-radius: 10px;
        }
        .switch-form-link {
            text-decoration: underline;
            cursor: pointer;
            color: rgb(100, 100, 250);
        }

        .drawingBuffer {
            width: 0;
            padding: 0;
        }

        .hidden{
            display: none;
        }
    </style>
</head>
<body>
    
    <div class="main">
        <div class="rectangle2"></div>
        <div class="login-container" id="mainCam">
            <div class="login-form" id="loginForm">
                <h2 class="text-center">PECOS!</h2>
                <p class="text-center">Login through QR code scanner.</p>

                <video id="interactive" class="viewport" width="415"></video>
            </div>

            <div class="qr-detected-container" style="display: none;">
                <form action="http://localhost/mvcpecos/controllers/login.php" method="POST" id="loginRedirectForm">
                    <!-- <h4 class="text-center">Maulana</h4> -->
                    <input type="hidden" id="detected-qr-code" name="qr-code">
                    <button type="submit" class="btn btn-dark form-control">Login</button>
                </form>
            </div>
        </div>
    </div>
        <!-- Registration Area -->
        <div class="registration-container">
        <div class="registration-form" id="registrationForm">
        <form action="../../models/add-user.php" method="POST">

            <div class="qr-code-container text-center" style="display: none;">
                <h3>Take a Picture of your QR Code and Login!</h3>
                <input type="hidden" id="generatedCode" name="generated_code">
                <div class="m-4" id="qrBox">
                    <img src="" id="qrImg">
                </div>
                <!-- <button type="submit" class="btn btn-dark">Back to Login Form.</button> -->
            </div>
        </form>
    </div>
</div>


<!-- Bootstrap Js -->   
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
        document.getElementById('detected-qr-code').value = content;
        document.getElementById('loginRedirectForm').submit();
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

document.addEventListener('DOMContentLoaded', startScanner);
    
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
        const registrationInputs = document.querySelector('.hide-registration-inputs');
        const h2 = document.querySelector('.registration-form > h2');
        const p = document.querySelector('.registration-form > p');
        const inputs = document.querySelectorAll('.registration input');
        const qrImg = document.getElementById('qrImg');
        const qrBox = document.getElementById('qrBox');

        registrationInputs.style.display = 'none';

        let text = generateRandomCode(10);
        $("#generatedCode").val(text);

        if (text === "") {
            alert("Please enter text to generate a QR code.");
            return;
        } else {
            const apiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(text)}`;

            // Generating image
            qrImg.src = apiUrl;
            qrBox.setAttribute("id", "qrBoxGenerated");
            qrCodeContainer.style.display = "";
            registrationCon.style.display = "";
            h2.style.display = "none";
            p.style.display = "none";
        }
    }

    // Ensure the scanner starts after the page loads
    document.addEventListener('DOMContentLoaded', startScanner);
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.onload = function() {
        var gagal = 0; // Define the variable in any case
        <?php
            if (isset($_SESSION['gagal'])) {
                echo "gagal = 1;";
                unset($_SESSION['gagal']);
            }
        ?>
        if (gagal === 1){
            var loginForm = document.getElementById('mainCam');
            loginForm.classList.add('hidden');
            Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to proceed to the next step. Please try again.',
                    confirmButtonText: 'OK'
            }).then(function() {
                setTimeout(function() {
                    loginForm.classList.remove('hidden');
                }, 250);
            }); 
        }
    }
</script>

</body>
</html>
