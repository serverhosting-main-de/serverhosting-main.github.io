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
            
            // Weiterleitung zur Startseite mit Erfolgsmeldung
            header('Location: login.php?success=1');
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
    <style>
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <?php if(isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <!-- Hier wird die Popup-Nachricht für den Erfolg angezeigt -->
    <div id="successPopup" class="popup alert alert-success">
        Login erfolgreich.
    </div>
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

    <script>
        // JavaScript, um das Popup anzuzeigen, wenn der Erfolgsparameter vorhanden ist
        document.addEventListener("DOMContentLoaded", function() {
            // Überprüfen, ob die URL-Parameter die Erfolgsmeldung enthalten
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                const successPopup = document.getElementById('successPopup');
                successPopup.style.display = 'block';
                // Automatisches Ausblenden des Popups nach 3 Sekunden
                setTimeout(function() {
                    successPopup.style.display = 'none';
                }, 3000);
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/script/index.js"></script>
</body>
</html>
