<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2> Cart</h2>
    <div id="cartItems">
        <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
            <?php foreach ($allItems as $item): ?>
                <?php if ($item['id'] == $id): ?>
                    <div class="cart-item">
                        <span class="item-name"><?= htmlspecialchars($item['name']) ?></span>
                        <span class="item-quantity"><?= htmlspecialchars($quantity) ?></span>
                        <span class="item-price"><?= htmlspecialchars($item['price']) ?></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <div class="cart-buttons">
        <button class="btn-cart" onclick="closeCartPopup()">Close</button>
        <button class="btn-cart" onclick="nextStep()">Next</button>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function nextStep() {
    $.ajax({
        type: "POST",
        url: "/mvcpecos/controllers/ProcessController.php",
        data: { action: 'nextStep' },
        success: function() {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Proceeding to the next step...',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/mvcpecos/views/pegawai/index.php";
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to proceed to the next step. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX error
            console.error('AJAX Error:', status, error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to proceed to the next step. Please try again.',
                confirmButtonText: 'OK'
            });
        }
    });
}

        </script>
</body>
</html>
