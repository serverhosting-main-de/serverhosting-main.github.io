<?php
// Datenbankverbindungsinformationen
$servername = "45.89.124.250"; // Hostname des Datenbankservers
$username = "root"; // Benutzername der Datenbank
$password = "Fkzx9p6g"; // Passwort der Datenbank
$database = "serverhosting_main"; // Name der Datenbank

// Verbindung zur Datenbank herstellen
$db = new mysqli($servername, $username, $password, $database);

// Überprüfen, ob die Verbindung erfolgreich hergestellt wurde
if ($db->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $db->connect_error);
}
?>
