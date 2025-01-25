<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 100%;
            height: 900px;
            background: #ffffff;
        }
        .rectangle-1 {
            position: absolute;
            width: 100%;
            height: 300px;
            left: 0;
            top: 0;
            background: #007B59;   
        }
        .rectangle-3 {
            position: absolute;
            width: 1270px;
            height: 676px;
            left: 130px;
            top: 197px;
            background: #FFFFFF;
            box-shadow: 0px 4px 140px -48px #007B59;
            border-radius: 10px;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        #main-content {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
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
        .btn {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .btn-delete {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="rectangle-1"></div>
<div class="rectangle-2"></div>
<div class="rectangle-3">
    <div class="container" id="main-content">
        <a href="../form/logout.php">Logout</a>
        <button class="btn" onclick="location.href='add_akun.php'">Add account</button>
        <table>
            <tr>
                <th>ID</th>
                <th>ID Meja</th>
                <th>Generated Code</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['id_meja']) ?></td>
                        <td><?= htmlspecialchars($user['generated_code']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td><span class="btn-delete" onclick="deleteAccount(<?= $user['id'] ?>)">🗑️</span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No accounts found</td></tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<script>
    function deleteAccount(id) {
        if (confirm('Are you sure you want to delete this account?')) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "?action=delete", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText === "success") {
                        alert('Account deleted');
                        location.reload(); // Reload the page to reflect the changes
                    } else {
                        alert('Error deleting account');
                    }
                }
            };
            xhr.send("id=" + id);
        }
    }
</script>
</body>
</html>
