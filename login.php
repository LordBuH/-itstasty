<?php
if (isset($_POST['submit'])) { // Überprüfen, ob das Login-Formular abgeschickt wurde
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Abrufen des Benutzers aus der Datenbank
  // Erstellen einer Datenbankverbindung
  $host = 'localhost';
  $db = 'itstasty';
  $user = 'root';
  $pass = '';
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $pdo = new PDO($dsn, $user, $pass);

  $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
  $stmt->execute([$username]);
  $user = $stmt->fetch();
  $salt = "1e26e2f251f1d21b2cfe55077a49f8c6";

  if ($user) { // Wenn der Benutzer gefunden wurde
    // Generieren des Hashes aus dem vom Benutzer eingegebenen Passwort und dem Salt aus der Datenbank
    $password = hash('sha256', $password . $user['salt']);

    // Überprüfen, ob der Hash des eingegebenen Passworts mit dem in der Datenbank gespeicherten Hash übereinstimmt
    if ($password === $user['Password']) {
      session_start();
      $_SESSION['username'] = $username;
      header('Location: index.php'); // Weiterleitung zur Startseite
      exit;
    } else {
      $error = 'Falsches Passwort';
    }
  } else {
    $error = 'Benutzername nicht gefunden';
  }
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