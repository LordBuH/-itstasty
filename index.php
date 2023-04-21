<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItsTastY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
    <style>
        
        .price {
            color: #d00a2ce6;
        }

        .shop-image {
            height: 180px;
            object-fit: contain;
        }

        .carousel-item img {
            height: 300px;
            object-fit: cover;
        }
        .carousel-caption {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.38728995015975143) 100%);
            left: 0;
            right: 0;
            bottom: 0;
        }
    </style>
</head>
<body>
<div class='menubar'>
    <h1>ItsTastY</h1>
</div>
<!-- Slider -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 0"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="img/cover0.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Jeden Tag was gutes.</h5>
              <p>Schnell und Einfach zum Mittagsgenus.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="img/cover1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Frühstücks Ideen</h5>
              <p>Für den perfektenstart in den Tag.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="img/cover2.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>ItsTastY</h5>
              <p>Top Gerichte, einfach und Schnell.</p>
            </div>
          </div>
        <div class="carousel-item">
          <img src="img/cover3.jpg" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Hier findet jeder sein Rezept.</h5>
            <p>Erstelle deibe eigenen Rezepte.</p>
          </div>
        </div>
      </div>
      </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
<!-- Slider -->
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