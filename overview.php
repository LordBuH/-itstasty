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
          .container{
            padding-top: 100px;
          }
          .search {
            position: relative;
          }
        </style>
</head>
<body>
<?php
  include 'content.php';
  GetNav("test");
?>
<div class='container mb-5'>
<div class='search'>
  <div>
    <form action="overview.php" method="post">
    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
      <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off" name="categories[]" value=1>
      <label class="btn me-2 btn-outline-primary rounded-pill" for="btncheck1">Frühstück</label>

      <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off" name="categories[]" value=2>
      <label class="btn me-2 btn-outline-primary rounded-pill" for="btncheck2">Mittagessen</label>

      <input type="checkbox" class="btn-check" id="btncheck3" autocomplete="off" name="categories[]" value=3>
      <label class="btn me-2 btn-outline-primary rounded-pill" for="btncheck3">Abendessen</label>

      <input type="checkbox" class="btn-check" id="btncheck4" autocomplete="off" name="categories[]" value=4>
      <label class="btn me-2 btn-outline-primary rounded-pill" for="btncheck4">Dessert</label>
  </div>
  <form class="d-flex" role="search">
    <input class="form-control me-2 mt-2 border rounded-pill" type="search" placeholder="search" id="search" name="search">
    <button class="btn btn-outline-success mt-2" type="submit" value="Submit">Search</button>
  </form>
</form>

  <div class='row g-3'>
  <?php
  if (isset($_POST['search']))
  {
    include 'search.php';

    if(isset($_POST['categories']))
    {
      $recipeList = GetSearchResult($_POST['search'], $_POST['categories']);
    }
    else
    {
      $recipeList = GetSearchResult($_POST['search'], null);
    }


    GetCart($recipeList);
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
