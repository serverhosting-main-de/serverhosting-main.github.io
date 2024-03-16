<?php
session_start();

// Annahme: Hier sollten Sie die Produkt-ID und andere Informationen validieren und speichern
if(isset($_GET['id'])) {
    $product_id = $_GET['id'];
    // Beispiel: Warenkorb in der Session speichern
    $_SESSION['cart'][] = $product_id;
}

// Nach dem Hinzufügen zum Warenkorb zur Produktseite zurückkehren
header('Location: index.php');
exit;
?>