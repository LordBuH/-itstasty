<?php
session_start();
// Einbindung der Datenbankverbindung
include 'db_conn.php';
include 'content.php';


if (isset($_POST['submit'])) { // Überprüfen, ob das Registrierungs-Formular abgeschickt wurde
  if(strlen($_POST['password']) > 7){
    if($_POST['password'] == $_POST['passwordToo']){
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $email = $_POST['email'];
      $userImg = $_FILES["img"];
      
      if (!empty($userImg['name'])) {
        // Dateiinformationen abrufen
        $fileName = $userImg['name'];
        $fileTmpName = $userImg['tmp_name'];
        $fileSize = $userImg['size'];
        $fileError = $userImg['error'];

      
      $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      $allowedExtensions = array('jpg', 'jpeg');
      if (in_array($fileExt, $allowedExtensions)) {
        // Überprüfen, ob keine Fehler aufgetreten sind
        if ($fileError === 0) {
          // Den Inhalt der Datei in ein BLOB umwandeln
          $fileData = file_get_contents($fileTmpName);

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
              $stmt->bind_param('sssssss', $firstname, $lastname, $username, $email, $salt, $password, $fileData);
              $stmt->execute();
              $ID = $stmt->insert_id;
              $_SESSION['userID'] = $ID;
              $_SESSION['username'] = $username;
              $_SESSION['userImg'] = $fileData;

              header('Location: user.php');
              exit;
          }
        } else {
          $error = 'Es ist ein Fehler beim Hochladen der Datei aufgetreten: ' . $fileError;
        }
      } else {
        $error = 'Es sind nur JPG/JPEG-Dateien erlaubt.';
      }
    } else {
      $error = 'Es wurde keine Datei ausgewählt.';
    }
    // Verbindung schließen
    $conn->close();
  } else{
      $error = 'Passwörter sind nicht identisch.';
    }
} else{
    $error = 'Das Passwort muss mindesten 8 Zeichen lang sein.';
  }
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
  GetNav('Registrierung');
  ?>
<div class="page-content d-flex align-items-center">
  <div class="container d-flex justify-content-center">
    <div class='col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5'>
      <div class='auth-card mt-5 mb-5'>
          <div class='logo-area d-flex justify-content-center'>
            <img id="header_logo" class="logo" src="assets/img/logo.png" />
          </div>     
        <form class="row g-3" method="post" enctype="multipart/form-data">
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
            <input type="password" class="form-control" id="floatingPassword" name="passwordToo" placeholder="Passwort wiederholen">
            <label for="floatingPassword">Passwort wiederholen</label>
          </div>
          <div>
            <input type="file" class="form-control" id="customFile" name="img"/>
          </div>
          <div class="d-grid gap-2 mb-3">
            <button class="btn btn-light btn-lg" type="submit"  name="submit" value="Registrieren">Registrierung</button>
          </div>
        </form>
        <?php
              if (isset($error)) { 
                echo"
                  <div class='d-flex justify-content-center'>
                  <p>$error</p>
                  </div>
                  ";
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