<?php
 // Einbindung der Datenbankverbindung
include 'db_conn.php';
include 'content.php';
session_start();

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
          echo"$password";
    // Überprüfen, ob der Hash des eingegebenen Passworts mit dem in der Datenbank gespeicherten Hash übereinstimmt
    if ($password === $user['Password']) {
      $_SESSION['userID'] = $user['ID'];
      $_SESSION['username'] = $username;
      $_SESSION['userImg'] = $user['UserImg'];
      header('Location: user.php');
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
      <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <?php 
    GetNav("Anmeldung")
  ?>
<div class="page-content d-flex align-items-center mt-5">
  <div class="container d-flex justify-content-center">
    <div class='col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5'>
      <div class='auth-card'>
        <div class='logo-area d-flex justify-content-center'>
          <img id="header_logo" class="logo" src="img/logo.png" />
        </div>        
  <form class="row g-3" method="post">
    <div class="form-floating">
      <input type="username" class="form-control" id="floatingInput" name="username" placeholder="Benutzername">
      <label for="floatingUsername">Benutzername</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Passwort">
      <label for="floatingPassword">Passwort</label>
    </div>
    <div class="d-grid gap-2">
      <button class="btn btn-light btn-lg" type="submit"  name="submit" value="Anmelden">Anmelden</button>
      <a class='btn btn-light btn-lg' href='registration.php' role='button'>Registrieren</a>
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