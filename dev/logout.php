<?php
// Starte die PHP-Sitzung
session_start();

// Beende die Sitzung
session_unset();
session_destroy();

// Leite den Benutzer zur Login-Seite weiter
header("Location: index.php");
exit;
?>
