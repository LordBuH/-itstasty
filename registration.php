<?php
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

  // Speichern der Benutzerdaten (hier nur ein Beispiel, Sie müssen Ihre eigene Datenbankverbindung verwenden)
  // Erstellen einer Datenbankverbindung
  $host = 'localhost';
  $db = 'itstasty';
  $user = 'root';
  $pass = '';
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $pdo = new PDO($dsn, $user, $pass);

  // Überprüfen, ob der Benutzername bereits existiert
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE username = ?');
  $stmt->execute([$username]);
  $result = $stmt->fetchColumn();

  if ($result) {
    $error = 'Benutzername bereits vergeben';
  } else {
    // Speichern der Benutzerdaten in der Datenbank
    $stmt = $pdo->prepare('INSERT INTO user (Firstname, Lastname, Username, Email, Salt, Password, UserImg) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$firstname, $lastname, $username, $email, $salt, $password, $userImg]);
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
</body>
</html>