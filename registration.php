<?php
// Einbindung der Datenbankverbindung
include 'db_conn.php';
include 'content.php';


if (isset($_POST['submit'])) { // Überprüfen, ob das Registrierungs-Formular abgeschickt wurde
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $userImg = $_POST["img"];

  // Generieren eines zufälligen Salts
  $salt = bin2hex(random_bytes(16));


  // Erzeugen des Hashes aus dem Passwort und dem Salt
  $password = hash('sha256', $password . $salt);

  // Überprüfen, ob der Benutzername bereits existiert
  $stmt = $conn->prepare('SELECT COUNT(*) FROM user WHERE username = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc()['COUNT(*)'];

  if ($result) {
    $error = 'Benutzername bereits vergeben';
  } else {

    // Speichern der Benutzerdaten in der Datenbank
    $stmt = $conn->prepare('INSERT INTO user (Firstname, Lastname, Username, Email, Salt, Password, UserImg) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('sssssss', $firstname, $lastname, $username, $email, $salt, $password, $userImg);
    $stmt->execute();
    header('Location: login.php'); // Weiterleitung zur Login-Seite
    exit;
  }

  // Verbindung schließen
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrierung</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      .page-content {
        margin-top: 60px;
      }
    </style>
</head>
<body>
  <?php
  GetNav("Registrierung");
  ?>
<div class="page-content d-flex align-items-center ">
  <div class="container d-flex justify-content-center">
    <div class='col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5'>
      <div class='auth-card'>
          <div class='logo-area d-flex justify-content-center'>
            <img id="header_logo" class="logo" src="img/logo.png" />
          </div>     
        <form class="row g-3" method="post">
          <div class="form-floating">
            <input type="firsname" class="form-control" id="floatingInput" name="firstname" placeholder="Vorname">
            <label for="floatingFirstname">Vorname</label>
          </div>
          <div class="form-floating">
            <input type="lastname" class="form-control" id="floatingInput" name="lastname" placeholder="Nachname">
            <label for="floatingLastnam">Nachname</label>
          </div>
          <div class="form-floating">
            <input type="username" class="form-control" id="floatingInput" name="username" placeholder="Benutzername">
            <label for="floatingUsername">Benutzername</label>
          </div>
          <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="E-Mail">
            <label for="floatingEmail">E-Mail</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Passwort">
            <label for="floatingPassword">Passwort</label>
          </div>
          <div class="form-floating">
            <input  type="file" id="floatingInput" name="img">
            <label for="floatingPassword">Passwort</label>
          </div>
          <div class="d-grid gap-2">
            <button class="btn btn-light btn-lg" type="submit"  name="submit" value="Registrieren">Registrierung</button>
          </div>
        </form>
        <?php
              if (isset($error)) { 
                echo"<p>$error</p>";
              } 
            ?>
      </div>
    </div>
  </div>
</div>
<?php
    GetFooter();
  ?>
</body>
</html>