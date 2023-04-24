<?php
if (isset($_POST['submit'])) { // Überprüfen, ob das Registrierungs-Formular abgeschickt wurde
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  // Generieren eines zufälligen Salts
  //$salt = bin2hex(random_bytes(16));
  $salt = "1e26e2f251f1d21b2cfe55077a49f8c6";

  // Erzeugen des Hashes aus dem Passwort und dem Salt
  $hashed_password = hash('sha256', $password . $salt);

  // Speichern der Benutzerdaten (hier nur ein Beispiel, Sie müssen Ihre eigene Datenbankverbindung verwenden)
  // Erstellen einer Datenbankverbindung
  $host = 'localhost';
  $db = 'mydatabase';
  $user = 'myusername';
  $pass = 'mypassword';
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $pdo = new PDO($dsn, $user, $pass);

  // Überprüfen, ob der Benutzername bereits existiert
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
  $stmt->execute([$username]);
  $result = $stmt->fetchColumn();

  if ($result) {
    $error = 'Benutzername bereits vergeben';
  } else {
    // Speichern der Benutzerdaten in der Datenbank
    $stmt = $pdo->prepare('INSERT INTO users (username, hashed_password, salt, email) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $hashed_password, $salt, $email]);
    header('Location: login.php'); // Weiterleitung zur Login-Seite
    exit;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registrierung</title>
</head>
<body>
  <h1>Registrierung</h1>
  <?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  <form method="post">
    <label for="username">Benutzername:</label>
    <input type="text" name="username" required><br>
    <label for="password">Passwort:</label>
    <input type="password" name="password" required><br>
    <label for="email">E-Mail-Adresse:</label>
    <input type="email" name="email" required><br>
    <input type="submit" name="submit" value="Registrieren">
  </form>
</body>
</html>