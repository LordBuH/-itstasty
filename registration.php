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
    <style>
          .container{
            padding-top: 100px;
            padding-right: 250px;
            padding-left: 250px;
          }
    </style>
</head>
<body>
  <?php
  GetNav("Registrierung");

 if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  <div class='container'>
  <div class="card" aria-hidden="true"> 

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
<div class="d-grid gap-2">
  <button class="btn btn-primary" type="submit"  name="submit" value="Registrieren">Registrierung</button>
</div>
</form>
</div>
</div>
</body>
</html>