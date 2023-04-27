<?php
// Einbindung der Datenbankverbindung
include 'db_conn.php';
include 'contentphp';


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
          .main{
            padding-top: 70px;
          }
    </style>
</head>
<body>
  <?php
  GetNav("Registrierung");

 if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  <div class='main'>
  <div class="card" aria-hidden="true"> 
  <form method="post">
    <label for="firstname">Vorname:</label>
    <input type="text" name="firstname" required><br>
    <label for="lastname">Nachname:</label>
    <input type="text" name="lastname" required><br>
    <label for="username">Benutzername:</label>
    <input type="text" name="username" required><br>
    <label for="email">E-Mail-Adresse:</label>
    <input type="email" name="email" required><br>
    <label for="password">Passwort:</label>
    <input type="password" name="password" required><br>
    <label for="img">Profilbild:</label>
    <input type="text" name="img" required><br>
    <input type="submit" name="submit" value="Registrieren">
  </form>
</div>
</div>
</body>
</html>