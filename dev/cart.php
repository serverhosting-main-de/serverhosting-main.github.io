<?php
session_start();
include '../assets/configs/config.php'; // Stellen Sie sicher, dass die Verbindung zur Datenbank hergestellt ist

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Berechnen Sie die Gesamtmenge der Produkte im Warenkorb
$total_items = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $total_items += $product['quantity'];
    }
}

// SQL-Abfrage, um die Produkte im Warenkorb abzurufen
$cart_products = [];
if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT * FROM products WHERE id IN ($product_ids)";
    $result = $db->query($sql);
    while ($row = $result->fetch_assoc()) {
        $row['quantity'] = $_SESSION['cart'][$row['id']]['quantity'];
        $cart_products[] = $row;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        /* Dark mode */
        body {
            background-color: #1e1e1e;
            color: #fff;
            padding-top: 70px; /* Platz für die Navbar */
        }
        .card {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="../index.html">Serverhosting-Main | Startseite</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <?php echo $total_items; ?></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Warenkorb</h2>
        <div class="row">
            <?php foreach ($cart_products as $product): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text">RAM: <?php echo $product['ram']; ?> MB</p>
                        <p class="card-text">Cores: <?php echo $product['cores']; ?></p>
                        <p class="card-text">IPs: <?php echo $product['ips']; ?></p>
                        <p class="card-text">Preis: <?php echo $product['price']; ?>€</p>
                        <p class="card-text">Menge: <?php echo $product['quantity']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
