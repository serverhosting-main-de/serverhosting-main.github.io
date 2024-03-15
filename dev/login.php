<?php
session_start();
include 'config.php';

// Überprüfen, ob der Benutzer bereits eingeloggt ist, falls ja, weiterleiten
if(isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Überprüfen, ob das Formular gesendet wurde
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Benutzeranmeldeinformationen abrufen
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL-Abfrage vorbereiten, um Benutzerdaten aus der Datenbank zu überprüfen
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    
    // SQL-Abfrage vorbereiten
    $stmt = $db->prepare($sql);
    
    // Parameter binden
    $stmt->bind_param('ss', $username, $password);
    
    // SQL-Abfrage ausführen
    $stmt->execute();
    
    // Ergebnis abrufen
    $result = $stmt->get_result();

    // Überprüfen, ob ein Benutzer mit den angegebenen Anmeldeinformationen gefunden wurde
    if ($result->num_rows == 1) {
        // Benutzer erfolgreich eingeloggt, Session-Variable setzen
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        
        // Weiterleitung zur Startseite
        header('Location: index.php');
        exit;
    } else {
        // Anmeldeinformationen sind ungültig, Fehlermeldung anzeigen
        $error = "Ungültiger Benutzername oder Passwort";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/style/login_register.css">
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <form action="" method="post">
        <div>
            <label for="username">Benutzername:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Passwort:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <p>Noch keinen Account? <a href="register.php">Registrieren</a></p>
</body>
</html>
