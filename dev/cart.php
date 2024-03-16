<?php
session_start();

// Produkte definieren (können aus der Datenbank abgerufen werden)
$products = [
    ['id' => 1, 'name' => 'Produkt 1', 'price' => 10],
    ['id' => 2, 'name' => 'Produkt 2', 'price' => 15],
    ['id' => 3, 'name' => 'Produkt 3', 'price' => 20],
];

// Funktion zum Hinzufügen eines Produkts zum Warenkorb
function addToCart($productId) {
    $_SESSION['cart'][$productId] = 1;
}

// Funktion zum Entfernen eines Produkts aus dem Warenkorb
function removeFromCart($productId) {
    unset($_SESSION['cart'][$productId]);
}

// Überprüfen, ob ein Produkt zum Warenkorb hinzugefügt oder entfernt wurde
if (isset($_POST['action'])) {
    $productId = $_POST['product_id'];
    if ($_POST['action'] === 'add') {
        addToCart($productId);
    } elseif ($_POST['action'] === 'remove') {
        removeFromCart($productId);
    }
}

// Gesamtsumme berechnen
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        foreach ($products as $product) {
            if ($product['id'] == $productId) {
                $total += $product['price'] * $quantity;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style/index.css" />
</head>
<body>
    <div class="container mt-5">
        <h2>Warenkorb</h2>
        <div id="cart-items">
            <?php if (!empty($_SESSION['cart'])): ?>
                <ul>
                    <?php foreach ($_SESSION['cart'] as $productId => $quantity): ?>
                        <?php foreach ($products as $product): ?>
                            <?php if ($product['id'] == $productId): ?>
                                <li>
                                    <?php echo $product['name']; ?> - <?php echo $product['price']; ?> €
                                    <button class="btn btn-sm btn-danger remove-item" data-product-id="<?php echo $productId; ?>">Entfernen</button>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Der Warenkorb ist leer.</p>
            <?php endif; ?>
        </div>
        <p><strong>Gesamtsumme:</strong> <?php echo $total; ?> €</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // AJAX-Anfrage zum Hinzufügen eines Produkts zum Warenkorb
            $('.add-to-cart').on('click', function() {
                var productId = $(this).data('product-id');
                $.post('cart.php', { action: 'add', product_id: productId }, function(data) {
                    $('#cart-items').html(data);
                });
            });

            // AJAX-Anfrage zum Entfernen eines Produkts aus dem Warenkorb
            $('.remove-item').on('click', function() {
                var productId = $(this).data('product-id');
                $.post('cart.php', { action: 'remove', product_id: productId }, function(data) {
                    $('#cart-items').html(data);
                });
            });
        });
    </script>
</body>
</html>
