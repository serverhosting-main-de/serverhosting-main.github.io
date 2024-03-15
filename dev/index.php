<?php
session_start();

// Überprüfen, ob der Benutzer nicht eingeloggt ist, dann weiterleiten
if(!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Serverhosting-Main | Startseite</title>
    <link
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/style/index.css" />
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="../index.html"
          >Serverhosting-Main | Startseite</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <?php if(isset($_SESSION['loggedin'])) { ?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5">
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="image-container">
            <img
              src="../assets/img/image_header.jpg"
              alt="Bildbeschreibung"
              class="img-fluid"
            />
            <div class="info-text">
              Serverhosting-Main | Startseite<br /><br />
              Wir sind ein prepaid-basierter Hosting-Anbieter, vertreten im NTT
              Rechenzentrum Frankfurt am Main mit modernen AMD EPYC KVM-Servern
              und im Skylink Rechenzentrum in Eygelshoven mit preiswerten Intel
              Xeon und leistungsstarken AMD Ryzen KVM-Servern.
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-6">
          <div class="filled-block">
            <p>Gefüllter Block mit Inhalt...</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="empty-block"></div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/script/index.js"></script>
  </body>
</html>
