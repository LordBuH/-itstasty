<?php
 // Einbindung der Datenbankverbindung
include 'db_conn.php';
include 'nav.php';

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Überprüfen, ob die Verbindung fehlerfrei hergestellt wurde
  if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
  }

  // Benutzer aus der Datenbank abrufen
  $stmt = $conn->prepare('SELECT * FROM user WHERE username = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user) {
    // Generieren des Hashes aus dem vom Benutzer eingegebenen Passwort und dem Salt aus der Datenbank
    $password = hash('sha256', $password . $user['Salt']);

    // Überprüfen, ob der Hash des eingegebenen Passworts mit dem in der Datenbank gespeicherten Hash übereinstimmt
    if ($password === $user['Password']) {
      session_start();
      $_SESSION['username'] = $username;
      header('Location: index.php');
      exit;
    } else {
      $error = 'Falsches Passwort';
    }
  } else {
    $error = 'Benutzername nicht gefunden';
  }

  // Verbindung schließen
  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</head>
<body>
  <?php 
  GetNav("Anmeldung");
  
  if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  <div>  <form method="post">
    <label for="username">Benutzername:</label>
    <input type="text" name="username" required><br>
    <label for="password">Passwort:</label>
    <input type="password" name="password" required><br>
    <input type="submit" name="submit" value="Anmelden">
    <button onclick="window.location.href='registration.php'">Registrieren</button>
  </form>
</div>

</body>
</html>