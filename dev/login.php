<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$errors = [];

include '../assets/configs/config.php';

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
    $sql = "SELECT * FROM users WHERE username = ?";
    
    // SQL-Abfrage vorbereiten
    $stmt = $db->prepare($sql);
    
    // Parameter binden
    $stmt->bind_param('s', $username);
    
    // SQL-Abfrage ausführen
    $stmt->execute();
    
    // Ergebnis abrufen
    $result = $stmt->get_result();

    // Überprüfen, ob ein Benutzer mit den angegebenen Anmeldeinformationen gefunden wurde
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Benutzer erfolgreich eingeloggt, Session-Variable setzen
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            
            // Weiterleitung zur Startseite
            header('Location: index.php');
            exit;
        } else {
            // Anmeldeinformationen sind ungültig, Fehlermeldung anzeigen
            $error = "Ungültiges Passwort";
        }
    } else {
        // Anmeldeinformationen sind ungültig, Fehlermeldung anzeigen
        $error = "Ungültiger Benutzername";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style/login_register.css">
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <form action="login.php" method="post">
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


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/script/index.js"></script>
</body>
</html>
