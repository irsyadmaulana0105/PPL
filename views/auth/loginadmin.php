<?php
session_start();
include '../../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah email ada dalam basis data
    $stmt_check_email = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result = $stmt_check_email->get_result();

    if ($result->num_rows > 0) {
        // Email ditemukan dalam basis data, lanjutkan untuk memeriksa kata sandi
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];

        if ($password === $stored_password) {
            // Store user data in session
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Set a cookie for the session
            setcookie("username", $row['username'], time() + (86400 * 30), "/", "", true, true); // Expires in 30 days
            setcookie("role", $row['role'], time() + (86400 * 30), "/", "", true, true); // Expires in 30 days

            // Redirect based on user role
            switch ($row['role']) {
                case 'user':
                    header("Location: ../user/menu.php");
                    break;
                case 'pegawai':
                    header("Location: ../pegawai/index.php");
                    break;
                case 'admin':
                    header("Location: ../admin/daftarakun.php");
                    break;
                default:
                    echo "Role tidak diketahui.";
                    break;
            }
            exit();
        } else {
            // Password tidak cocok, arahkan kembali ke halaman login dengan pesan kesalahan
            header("Location: login.php?login_failed=true&email_exists=true");
            exit();
        }
    } else {
        // Email tidak ditemukan dalam basis data, arahkan kembali ke halaman login dengan pesan kesalahan
        header("Location: login.php?login_failed=true&email_exists=false");
        exit();
    }

    $stmt_check_email->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="rectangle2"></div>
    <div class="rectangle3959">
        <div class="create-account">Login Tel!</div>
        <div class="enter-email">Enter your email!</div>
        <form action="login.php" method="POST">
            <div class="group9">
                <input type="text" name="email" class="email" placeholder="Email">
                <div class="user_alt"></div>
            </div>
            
            <div class="group10">
                <input type="password" name="password" class="password" placeholder="Password">
                <div class="lock"></div>
            </div>
            
            <div class="group11">
                <button type="submit" class="login">Login</button>
            </div>
        </form>
    </div>
    <div class="rectangle3960"></div>

    <div class="welcome-back">Welcome back!</div>
    <div class="login-info">To keep connected with us please login with your personal info</div>
</body>
</html>
<script src="script.js"></script>

<style>
body {
    position: relative;
    width: 100%;
    min-height: 100vh;
    background: #DEEFE9;
    margin: 0;
    font-family: 'Poppins', sans-serif;
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


.rectangle3959 {
    position: absolute;
    width: 80%; 
    height: 60%; 
    left: 10%; 
    top: 20%;
    background: #E9E8E4;
    box-shadow: 0px 4px 40.1px #007B59;
    border-radius: 20px;
}


.rectangle3960 {
    position: absolute;
    width: 30%; 
    height: 60%;
    left: 10%; 
    top: 20%;
    background: rgba(0, 123, 89, 0.6);
    border-radius: 20px;
}


.group9 {
    position: absolute;
    width: 26%; 
    height: 15%; 
    left: 58%; 
    top: 33%;   
    background: rgba(103, 177, 157, 0.4);
}



.email {
    position: absolute;
    width: 75%; 
    height: 50%; 
    left: 5%; 
    top: 25%; 
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 600;
    font-size: 1vw;
    line-height: 24px;
    display: flex;
    align-items: center;
    letter-spacing: 0.09em;
    color: rgba(0, 0, 0, 0.6);
    background-color: transparent;
    border: none;
    outline: none;
    
}


.user_alt {
    position: absolute;
    width: 30px;
    height: 30px;
    left: 20px;
    top: 7px;
}


.group10 {
    position: absolute;
    width: 26%; 
    height: 15%; 
    left: 58%;
    top: 51%;
    background: rgba(103, 177, 157, 0.4);
}


.password {
    position: absolute;
    width: 75%; 
    height: 50%;
    left: 5%; 
    top: 25%;
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    display: flex;
    align-items: center;
    letter-spacing: 0.09em;
    color: rgba(0, 0, 0, 0.6);
    background-color: transparent;
    border: none;
    outline: none;
}


.group11 {
    position: absolute;
    width: 13%; 
    height: 15%; 
    left: 64%; 
    top: 75%;
    display: inline-block;
    background: rgba(103, 177, 157, 0.4);
    border-radius: 63px;
}

.login {
    position: absolute;
    width: 70%; 
    height: 60%; 
    left: 15%; 
    top: 22%;
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    letter-spacing: 0.2em;
    color: #007B59;
    cursor: pointer;
    border: none;
    background-color: transparent;
}


/* Create Account */
.create-account {
    position: absolute;
    width: 60%; 
    left: 41%; 
    top: 7%; 
    font-size: 2.5vw;
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 600;
    line-height: 100%;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    letter-spacing: -0.04em;
    color: #007B59;
}


.welcome-back {
    position: absolute;
    width: 24%; 
    left: 13%; 
    top: 42%; 
    font-size: 2.5vw;
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 600;
    line-height: 100%;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    letter-spacing: -0.04em;
    color: #FFFFFF;
}


.login-info {
    position: absolute;
    width: 20%; 
    left: 15%; 
    top: 53%; 
    font-size: 1vw;
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 600;
    line-height: 24px;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    letter-spacing: -0.06em;
    color: #FFFFFF;
}

/* Enter your email! */
.enter-email {
    position: absolute;
    width: 20%; 
    left: 61%; 
    top: 20%; 
    font-size: 1vw;
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 600;
    line-height: 24px;
    display: flex;
    align-items: center;
    text-align: center;
    justify-content: center;
    letter-spacing: 0.09em;
    color: #007B59;
}

.notification {
    position: fixed;
    top: 50px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #f44336;
    color: white;
    padding: 15px 30px;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: opacity 0.5s ease-in-out;
    opacity: 0;
    visibility: hidden;
}

.notification.show {
    opacity: 1;
    visibility: visible;
}
</style>