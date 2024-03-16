<?php
session_start();
include '../assets/configs/config.php'; // Stellen Sie sicher, dass die Verbindung zur Datenbank hergestellt ist

// Überprüfen, ob der Warenkorb nicht leer ist
if (!empty($_SESSION['cart'])) {
    // Summieren Sie die Gesamtpreise aller Produkte im Warenkorb
    $total_price = 0;
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $sql = "SELECT price FROM products WHERE id=$product_id";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_price += $row['price'] * $product['quantity']; // Korrigierte Zeile
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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
            <?php if(isset($_SESSION['loggedin'])) { ?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i>
              <?php 
              // Anzeigen der Anzahl der Artikel im Warenkorb
              if (!empty($_SESSION['cart'])) {
                  $total_items = count($_SESSION['cart']);
                  echo "<span class='badge badge-light'>$total_items</span>";
              } ?>
              </a>
            </li>
            <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5">
        <h2>Warenkorb</h2>
        <div class="row mt-4">
            <?php if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $product_id => $product) {
                    $sql = "SELECT * FROM products WHERE id=$product_id";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <p class="card-text">Preis: €<?php echo number_format($row['price'], 2, ',', '.'); ?></p>
                                    <p class="card-text">Menge: <?php echo $product['quantity']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else { ?>
                <div class="col">
                    <p>Der Warenkorb ist leer.</p>
                </div>
            <?php } ?>
        </div>
        <?php if (!empty($_SESSION['cart'])) { ?>
            <p class="text-right">Gesamtpreis: €<?php echo number_format($total_price, 2, ',', '.'); ?></p>
            <a href="#" class="btn btn-primary">Zur Kasse gehen</a>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
