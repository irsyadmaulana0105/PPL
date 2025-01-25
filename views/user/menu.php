<?php
require_once __DIR__ . '/../../models/MenuItem.php';
if ($_SESSION['role'] == "employee"){
    header("Location: http://localhost/mvcpecos/views/pegawai/index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pecos</title>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./public/css/style.css">
    <script>
        window.addEventListener('beforeunload', function (e) {
            window.location.href = "http://localhost/mvcpecos/views/auth/logout.php";
        });
        //(15 minutes * 60 seconds * 1000 milliseconds)
        setTimeout(function() {
            window.location.href = "http://localhost/mvcpecos/views/auth/logout.php";
        }, 60 * 60 * 1000);

    </script>
</head>
<body>
    <nav class="navbar">
        <!-- <div class="circle"><i class='bx bx-laptop'></i></div> -->
        <h2 style="color: green; padding: 10px;">Meja <?=$_SESSION['id_meja']?></h2>
        <div class="navbar-nav">
            <a href="#" onclick="showCategory('drinks')">Drinks</a>
            <a href="#" onclick="showCategory('food')">Food</a>
            <a href="#" onclick="showCategory('snacks')">Snack</a>
            <a href="../mvcpecos/views/auth/logout.php">logout</a>
        </div>
        <div class="navbar-extra">
            <a href="#" class="navbar-logo">PE<span>COS</span>.</a>
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>

    <div class="container">
        <div class="header-container">
            <h1>Whoever walks on his path <br> then he will come to it</h1>
            <a href="#" class="btn-cart" style="margin-top: 100px;" onclick="openCartPopup()">Go to Cart</a>
        </div>
        
        
        <!-- Drinks -->
        <div id="drinks" class="card-group">
            <?php foreach ($drinkItems as $item): ?>
                <div class="card">  
                    <div class="card-body text-center">
                    <img src="<?= "public/". $item['image']?>" class="menu-card-img" width="80px" height="100px">
                        <h2><?= htmlspecialchars($item['name']) ?></h2>
                        <!-- <h2><?= htmlspecialchars($item['price']) ?></h2> -->
                        <div class="stock-row">
                            <i onclick="updateStock(<?= $item['id'] ?>, 'kurang')" class='bx bxs-minus-square icon'></i>
                            <?php 
                            $stok = 0;
                            foreach ($cart as $a):
                                if ($a['id_menu'] == $item['id']){
                                    $stok = $a['stock'];
                                }
                            endforeach;?>
                            <span id="stock-<?= $item['id'] ?>" class="counter"><?= $stok?></span>
                            <i onclick="updateStock(<?= $item['id'] ?>, 'tambah')" class='bx bxs-plus-square icon'></i>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Food -->
        <div id="food" class="card-group">
            <?php foreach ($foodItems as $item): ?>
                <div class="card">
                    <div class="card-body text-center">
                    <img src="<?= "public/". $item['image']?>" class="menu-card-img" width="80px" height="100px">
                        <h2><?= htmlspecialchars($item['name']) ?></h2>
                        <div class="stock-row">
                            <i onclick="updateStock(<?= $item['id'] ?>, 'kurang')" class='bx bxs-minus-square icon'></i>
                            <?php 
                            $stok = 0;
                            foreach ($cart as $a):
                                if ($a['id_menu'] == $item['id']){
                                    $stok = $a['stock'];
                                }
                            endforeach;?>
                            <span id="stock-<?= $item['id'] ?>" class="counter"><?= $stok?></span>
                            <i onclick="updateStock(<?= $item['id'] ?>, 'tambah')" class='bx bxs-plus-square icon'></i>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Snacks -->
        <div id="snacks" class="card-group">
            <?php foreach ($snackItems as $item): ?>
                <div class="card">
                    <div class="card-body text-center">
                    <img src="<?= "public/". $item['image']?>" class="menu-card-img" width="80px" height="100px">                       
                        <h2><?= htmlspecialchars($item['name']) ?></h2>
                        <div class="stock-row">
                            <i onclick="updateStock(<?= $item['id'] ?>, 'kurang')" class='bx bxs-minus-square icon'></i>
                            <?php 
                            $stok = 0;
                            foreach ($cart as $a):
                                if ($a['id_menu'] == $item['id']){
                                    $stok = $a['stock'];
                                }
                            endforeach;?>
                            <span id="stock-<?= $item['id'] ?>" class="counter"><?= $stok?></span>
                            <i onclick="updateStock(<?= $item['id'] ?>, 'tambah')" class='bx bxs-plus-square icon'></i>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>

    <div id="cartPopup" class="modal">
        <div class="modal-content">
            <h2>Cart.</h2>
            <div id="cartItems">
            <?php foreach ($cart as $item): ?>
                <?php if ($item['stock'] > 0): ?>
                <div class="cart-item">
                    <span class="item-name"><?= htmlspecialchars($item['nama']) ?></span>
                    <span class="item-quantity"><?= htmlspecialchars($item['stock']) ?></span>
                    <span class="item-price"><?= htmlspecialchars($item['price']) ?></span>
                    <span class="item-price"><?= htmlspecialchars($item['total']) ?></span>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
            <div class="cart-buttons">
                <button class="btn-cart" onclick="closeCartPopup()">Close</button>
                <button class="btn-cart" onclick="nextStep()" type="button">Next</button>
            </div>
        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var id_user = <?= isset($_SESSION['id_meja']) ? $_SESSION['id_meja'] : 'null' ?>;
        
        function removeFromDatabase(id_menu) {
    $.ajax({
        type: "POST",
        url: "/mvcpecos/controllers/MenuController.php",
        data: { action: "delete", id_menu: id_menu },
        success: function(response) {
        },
        error: function(xhr, status, error) {
            console.error("Error while deleting item from database:", error);
        }
    });
}


function updateStock(id, action) {
    const stockElement = document.getElementById('stock-' + id);
    let currentStock = parseInt(stockElement.innerText);

    if (action === "tambah") {
        stockElement.innerText = currentStock + 1;
    } else if (action === "kurang") {
        if (currentStock > 0) {
            stockElement.innerText = currentStock - 1;
        }
    }

    $.ajax({
        type: "POST",
        url: "/mvcpecos/controllers/MenuController.php",
        data: "action="+ action +"&id_user=" + id_user + "&id_menu=" + id,
        success: function(response) {
            const main = document.getElementById('cartItems');
            while (main.firstChild) {
                main.removeChild(main.firstChild);
            }

            response.forEach(function(item) {
                if (item.stock > 0){

                    const cartItem = document.createElement('div');
                    cartItem.className = 'cart-item';

                    const itemName = document.createElement('span');
                    itemName.className = 'item-name';
                    itemName.textContent = item.nama; // Removed the double quotes
                    cartItem.appendChild(itemName);

                    // Buat span untuk item quantity
                    const itemQuantity = document.createElement('span');
                    itemQuantity.className = 'item-quantity';
                    itemQuantity.textContent = item.stock; // Removed the double quotes
                    cartItem.appendChild(itemQuantity);

                    const itemPrice = document.createElement('span');
                    itemPrice.className = 'item-quantity';
                    itemPrice.textContent = item.price; // Removed the double quotes
                    cartItem.appendChild(itemPrice);

                    // Buat span untuk item price
                    const itemTotal = document.createElement('span');
                    itemTotal.className = 'item-price';
                    itemTotal.textContent = item.total; // Removed the double quotes
                    cartItem.appendChild(itemTotal);

                    // Buat button untuk delete
                    const deleteButton = document.createElement('button');
                    deleteButton.className = 'delete-button';
                    deleteButton.textContent = 'Delete';
                    deleteButton.onclick = function() {
                        removeFromCart("S");
                    };
                    // cartItem.appendChild(deleteButton);

                    const main = document.getElementById('cartItems');
                    main.appendChild(cartItem);
                }
            });
        }
    });
}
        
function nextStep() {
    
    $.ajax({
        type: "POST",
        url: "/mvcpecos/controllers/ProcessController.php",
        data: "action=nextStep",
        success: function() {
    Swal.fire({
        title: 'Berhasil!',
        text: 'silakan Lanjut Kekasir.',
        icon: 'success',
        // confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed || result.isDismissed) {
            let cartItemsDiv = document.getElementById('cartItems');
            cartItemsDiv.innerHTML = '';
            
            const stockElements = document.querySelectorAll('[id^="stock-"]');
                    stockElements.forEach(function(stockElement) {
                        stockElement.innerText = 0;
            });
        }
    });
},
    });
}


    function closeCartPopup() {
        document.getElementById('cartPopup').style.display = 'none';
    }


    function showCategory(category) {
            var cardGroups = document.getElementsByClassName('card-group');
            for (var i = 0; i < cardGroups.length; i++) {
                cardGroups[i].style.display = 'none';
            }

            var selectedCategory = document.getElementById(category);
            if (selectedCategory) {
                selectedCategory.style.display = 'flex';
            }
        }

        function openCartPopup() {
            document.getElementById('cartPopup').style.display = 'block';
        }

        function closeCartPopup() {
            document.getElementById('cartPopup').style.display = 'none';
        }

        showCategory('drinks');
    </script>
</body>
</html>
