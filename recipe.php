<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItsTastY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
        <style>
          .main{
            padding-top: 50px;
          }

            .rate {
                float: left;
                height: 46px;
                padding: 0 10px;
            }
            .rate:not(:checked) > input {
                position:absolute;
                top:-9999px;
            }
            .rate:not(:checked) > label {
                float:right;
                width:1em;
                overflow:hidden;
                white-space:nowrap;
                cursor:pointer;
                font-size:30px;
                color:#ccc;
            }
            .rate:not(:checked) > label:before {
                content: '★ ';
            }
            .rate > input:checked ~ label {
                color: #ffc700;    
            }
            .rate:not(:checked) > label:hover,
            .rate:not(:checked) > label:hover ~ label {
                color: #deb217;  
            }
            .rate > input:checked + label:hover,
            .rate > input:checked + label:hover ~ label,
            .rate > input:checked ~ label:hover,
            .rate > input:checked ~ label:hover ~ label,
            .rate > label:hover ~ input:checked ~ label {
                color: #c59b08;
            }
        </style>

  <?php
  include 'content.php';
  //GetNav("test");

  ?>

</head>
<body>
  <!--
  <form action="search.php" method="post">
    <label for="input">Input:</label>
    <input type="text" id="search" name="search">
    <input type="test" name="categories[1]" value=1>
    <input type="test" name="categories[2]" value=2>
    <input type="submit" value="Submit">
  </form>
  -->
  <div class='container mt-5'>
  <div class='row g-3'>
  <?php
  include 'query.php';

  if (isset($_GET['rezept']))
  {
    $rezept = GetRecipeDataById($_GET['rezept']);

    foreach($rezept as $rz)
    {
        echo $rz->Name;

        foreach($rz->ingredientsList as $igl)
        {
            echo $igl->IngredientName;
        }

    }
  }

  if (isset($_POST['rate']))
  {
    echo "RATE" . $_POST['rate'];
  }
 
  ?>

<form action="recipe.php" method="post">
    <div class="rate" id="rate">
        <input type="radio" id="star5" name="rate" value="5" />
        <label for="star5" title="text">5 stars</label>
        <input type="radio" id="star4" name="rate" value="4" />
        <label for="star4" title="text">4 stars</label>
        <input type="radio" id="star3" name="rate" value="3" />
        <label for="star3" title="text">3 stars</label>
        <input type="radio" id="star2" name="rate" value="2" />
        <label for="star2" title="text">2 stars</label>
        <input type="radio" id="star1" name="rate" value="1" />
        <label for="star1" title="text">1 star</label>
    </div>
    <input type="submit" name="submit" value="Submit me!" />
</form>


  </div>
  </div>

</body>
<footer>
<?php
  //GetFooter();
  ?>
</footer>