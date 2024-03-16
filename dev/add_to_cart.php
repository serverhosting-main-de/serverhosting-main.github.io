<?php
session_start();
include '../assets/configs/config.php'; // Stellen Sie sicher, dass die Verbindung zur Datenbank hergestellt ist

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['loggedin'])) {
    // Benutzer ist nicht eingeloggt, daher Umleitung zur Login-Seite
    header("Location: login.php");
    exit; // Beenden Sie das Skript, um sicherzustellen, dass nichts weiter ausgeführt wird
}

// Überprüfen, ob eine Produkt-ID übergeben wurde
if(isset($_GET['id'])) {
    // Produkt-ID aus der GET-Anfrage erhalten
    $product_id = $_GET['id'];
    
    // Fügen Sie die Produkt-ID zum Warenkorb in der Benutzersitzung hinzu
    if(isset($_SESSION['cart'])) {
        // Wenn bereits Produkte im Warenkorb sind, fügen Sie die neue Produkt-ID hinzu
        $_SESSION['cart'][] = $product_id;
    } else {
        // Wenn der Warenkorb noch leer ist, initialisieren Sie ihn mit der Produkt-ID
        $_SESSION['cart'] = array($product_id);
    }
    
    // Optional: Umleitung zur Produkte-Seite oder einer anderen Seite nach dem Hinzufügen zum Warenkorb
    header("Location: products.php");
    exit; // Beenden Sie das Skript, um sicherzustellen, dass nichts weiter ausgeführt wird
} else {
    // Wenn keine Produkt-ID übergeben wurde, leiten Sie zur Produkte-Seite weiter
    header("Location: products.php");
    exit; // Beenden Sie das Skript, um sicherzustellen, dass nichts weiter ausgeführt wird
}
?>
