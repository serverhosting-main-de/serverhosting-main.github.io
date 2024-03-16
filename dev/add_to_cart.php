<?php
session_start();
include '../assets/configs/config.php'; // Stellen Sie sicher, dass die Verbindung zur Datenbank hergestellt ist

// Überprüfen, ob ein Benutzer eingeloggt ist
if (!isset($_SESSION['loggedin'])) {
    // Weiterleitung zur Login-Seite
    header('Location: login.php');
    exit;
}

// Überprüfen, ob eine Produkt-ID übergeben wurde
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Überprüfen, ob das Produkt bereits im Warenkorb ist
    if(isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        // Produkt zum Warenkorb hinzufügen
        $sql = "SELECT * FROM products WHERE id=$product_id";
        $result = $db->query($sql);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['cart'][$product_id] = array(
                "quantity" => 1,
                "price" => $row['price']
            );
        } else {
            $message = "Produkt nicht gefunden";
        }
    }
}

// Weiterleitung zur Produkte-Seite
header('Location: products.php');
?>
