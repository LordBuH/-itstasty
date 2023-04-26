<?php
 // Einbindung der Datenbankverbindung
include 'db_conn.php';

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
  <title>Anmeldung</title>
</head>
<body>
  <h1>Anmeldung</h1>
  <?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  <form method="post">
    <label for="username">Benutzername:</label>
    <input type="text" name="username" required><br>
    <label for="password">Passwort:</label>
    <input type="password" name="password" required><br>
    <input type="submit" name="submit" value="Anmelden">
    <button onclick="window.location.href='registration.php'">Registrieren</button>
  </form>
</body>
</html>