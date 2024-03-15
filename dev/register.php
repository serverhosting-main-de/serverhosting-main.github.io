<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$errors = [];

include '../assets/configs/config.php';

// Überprüfen, ob das Registrierungsformular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Überprüfen und Validieren der Eingaben
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Überprüfen, ob Passwort und Bestätigung übereinstimmen
    if ($password != $confirm_password) {
        $errors[] = "Die Passwörter stimmen nicht überein.";
    }

    // Wenn keine Fehler aufgetreten sind, Benutzer zur Datenbank hinzufügen
    if (empty($errors)) {
        // Passwort hashen, bevor es in die Datenbank gespeichert wird
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // SQL-Abfrage zum Einfügen des Benutzers in die Datenbank
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        // SQL-Abfrage vorbereiten
        $stmt = $db->prepare($sql);
        
        // Parameter binden
        $stmt->bind_param('sss', $username, $email, $hashed_password);
        
        // SQL-Abfrage ausführen
        if ($stmt->execute()) {
            // Weiterleitung zur Login-Seite mit Erfolgsmeldung
            header('Location: login.php?success=1');
            exit;
        } else {
            $errors[] = "Fehler beim Hinzufügen des Benutzers zur Datenbank: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style/login_register.css">
</head>
<body>
    <div class="container login-container">
        <h2 class="login-heading">Registrieren</h2>
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form class="login-form" action="register.php" method="post">
            <div class="form-group">
                <label for="username">Benutzername</label>
                <input type="text" id="username" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="confirm_password">Passwort bestätigen</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Registrieren</button>
            </div>
            <div class="register-link">
                <p>Sie haben bereits ein Konto? <a href="login.php">Hier einloggen</a>.</p>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
