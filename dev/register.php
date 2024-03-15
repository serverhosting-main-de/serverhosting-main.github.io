<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrieren</title>
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
    <div class="container">
        <h2>Registrieren</h2>
        <!-- Hier wird die Popup-Nachricht angezeigt -->
        <div id="successPopup" class="popup alert alert-success">
            Registrierung erfolgreich.
        </div>
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label>Benutzername</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Passwort</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Passwort bestätigen</label>
                <input type="password" name="confirm_password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrieren">
            </div>
            <p>Sie haben bereits ein Konto? <a href="login.php">Hier einloggen</a>.</p>
        </form>
    </div>

    <script>
        // JavaScript, um das Popup anzuzeigen
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
