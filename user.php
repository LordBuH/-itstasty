<?php
include 'content.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nutzer</title>
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
    GetNav("");
?>
<div>
<div>
    <?php
        if(isset($_SESSION['userID'])){
            $userID = $_SESSION['userID'];
            $username = $_SESSION['username'];
            $userImg = $_SESSION['userImg'];
            echo"
                <div class'container mt-5'>
                    <p>$userID</p>
                    <p>$username</p>
                    <img src='data:image/jpeg;base64," . base64_encode($userImg) . "'>
                    <a href='addrecipe.php'>Registrieren</a>
                </div>
            ";
       }else{
        header('Location: login.php');
       }
    ?>
  </div>
</div>
<?php
  GetFooter();
?>
</body>
</html>