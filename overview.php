<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktbuch</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
<div class='menubar'>
    <h1>ItsTastY</h1>
</div>
<div class='main'>
    <div class='content'>
    <?php
    $headline = "Herzlich willkommen";
    echo '<h1>' . $headline . '</h1>';
    echo '<p>Dies ist die Startseite.</p>';    
    ?>
    </div>
</div>
    <div class="footer">
    <p>(C) ItsTastY-Team.</p>
    </div>
</body>
</html>