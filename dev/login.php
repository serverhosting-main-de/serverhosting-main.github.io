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
