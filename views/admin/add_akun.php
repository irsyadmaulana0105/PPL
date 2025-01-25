<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .rectangle-1 {
            width: 100%;
            height: 150px;
            background: #007B59;
        }

        .add-account {
            position: absolute;
            top: 10%;
            left: 8%;
            font-weight: 600;
            font-size: 25px;
            line-height: 32px;
            color: #FFFFFF;
        }

        .rectangle-3 {
            width: 90%;
            max-width: 1270px;
            background: #FFFFFF;
            box-shadow: 0px 4px 140px -48px #007B59;
            border-radius: 10px;
            padding: 20px;
        }

        .input-field {
            width: 100%;
            font-size: 25px;
            font-family: times;
            height: 69px;
            border: 1px solid #000000;
            border-radius: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .input-label {
            font-weight: 600;
            font-size: 16px;
            line-height: 21px;
            color: #000000;
            margin-bottom: 10px;
            display: block;
        }

        .save-button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 94px;
            height: 41px;
            background: linear-gradient(180deg, #03A427 0%, #013E0F 100%);
            border-radius: 10px;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 16px;
            line-height: 21px;
            text-align: center;
            cursor: pointer;
            border: none;
        }

        @media (max-width: 768px) {
            .input-field {
                font-size: 20px;
                height: 50px;
            }

            .save-button {
                width: 100px;
                height: 50px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="rectangle-1"></div>
    <div class="add-account">Add account</div>
    <div class="rectangle-3">
        <?php if (isset($message)) : ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label class="input-label">Username *</label>
            <input type="text" name="username" class="input-field" required>

            <label class="input-label">Email *</label>
            <input type="email" name="email" class="input-field" required>

            <label class="input-label">Password *</label>
            <input type="password" name="password" class="input-field" required>

            <label class="input-label">Role *</label>
            <select name="role" class="input-field" required>
                <option value="">Select a role</option>
                <option value="pegawai">Pegawai</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" class="save-button">Save</button>
        </form>
    </div>
</body>
</html>
