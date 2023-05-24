<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rezept hinzufügen</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      .page-content {
        margin-top: 200px;
      }
    </style>
</head>
<body>
<?php
  include 'db_conn.php';
  include 'content.php';
  include 'query.php';
  session_start();
  if(isset($_SESSION['userID'])){
    $userID = $_SESSION['userID'];
    $username = $_SESSION['username'];
    $userImg = $_SESSION['userImg'];
  }
  else{
    header('Location: login.php');
  }

  if (isset($_POST['submit'])) {
  // Überprüfen, ob das Formular abgeschickt wurde
    $name = $_POST['name'];
    $instruction = $_POST['instruction'];
    $time = $_POST['time'];
    $categorie = $_POST['categorie'];
    $recipeImg = $_POST['recipeImg'];

    $ingredients = $_POST['ingredients'];
    $quantityIDs = $_POST['quantityID'];
    $quantityValues = $_POST['quantityValue'];
    $count = is_array($ingredients) ? count($ingredients) : 0;
    $tests = array();
    for ($i = 0; $i < $count; $i++) {
      $test = new stdClass();
      $test->Name = $ingredients[$i];
      $test->QuantityID = $quantityIDs[$i];
      $test->QuantityValue = $quantityValues[$i];
      array_push($tests, $test);
    }
    CreateRecipe($userID, $name, $instruction, $time, $recipeImg, $categorie, $tests);
  $info = 'Rezept wurde erfolgreich in die DB geladen.';
}

$conn->close(); 

  GetNav("");
?>
<div class="page-content d-flex align-items-center mt-5">
  <div class="container d-flex justify-content-center">
    <div class='col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5'>
      <div class='auth-card mt-5 mb-5'>
        <div class='logo-area d-flex justify-content-center'>
          <img id="header_logo" class="logo" src="assets/img/logo.png" />
        </div>        
        <form class="row g-3" method="post">
          <div class="form-floating">
            <input type="name" class="form-control" id="floatingInput" name="name" placeholder="Name">
            <label for="floatingname">Name</label>
          </div>       
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" name='time' placeholder='Zeit'>
            <label for="floatingtime">Zeit</label>
          </div>    
          <div class="form-floating mt-2">
              <input type="instruction" class="form-control" name='instruction' placeholder='Zubereitung'>
              <label>Zubereitung</label>
            </div> 
            <div class="form-floating mt-2">
                <select class="form-select" name='categorie' aria-label="Default select example">
                  <option selected>Kategorie</option>
                  <option value="1">Frühstück</option>
                  <option value="2">Mittagessen</option>
                  <option value="3">Abendessen</option>
                  <option value="4">Dessert</option>
                </select>
            </div>   
          <div class="form-floating">
            <input  type='file' id='floatingInput' name='recipeImg' accept='image/jpeg'>
          </div>
          <div id="zutaten-container">
            <div class="form-floating mt-2">
              <input type="ingredients" class="form-control" name='ingredients[]' placeholder='Zutat'>
              <label>Zutat</label>
            </div> 
            <div class="form-floating mt-2">
              <input type="instruction" class="form-control" name='quantityValue[]' placeholder='Menge'>
              <label>Menge</label>
            </div>  
            <div class="form-floating mt-2">
                <select class="form-select" name='quantityID[]' aria-label="Default select example">
                  <option selected>Mengen Art</option>
                  <option value="1">mg</option>
                  <option value="2">g</option>
                  <option value="3">kg</option>
                  <option value="4">ml</option>
                  <option value="5">l</option>
                  <option value="6">Stück</option>
                  <option value="7">Esslöffel</option>
                  <option value="8">Teelöffel</option>
                </select>
            </div>     
          </div>

          <div id="zutaten-button" class="d-grid gap-2">
            <button class="btn btn-light btn-lg" type="button" onclick="addZutat()">Weitere Zutat hinzufügen</button>
          </div>

          <div class="d-grid gap-2">
            <button class="btn btn-light btn-lg" type="submit"  name="submit" value="Hochladen">Hochladen</button>
          </div>
        </form>
        <?php
          if (isset($error)) { 
            echo"<p>$error</p>";
          } 
          if (isset($info)) { 
            echo"<p>Weiterleitung zur Einzelansicht des neunen Rezepts.</p>";
          } 
        ?>
      </div>
    </div>
  </div>
</div>
<script>
  function addZutat() {
    var container = document.getElementById("zutaten-container");

    var IngredientDiv = document.createElement("div");
    IngredientDiv.classList.add("form-floating");
    IngredientDiv.classList.add("mt-2");

    var inputIngredient = document.createElement("input");
    inputIngredient.type = "ingredients";
    inputIngredient.classList.add("form-control");
    inputIngredient.name = "ingredients[]";
    inputIngredient.placeholder = "Zutat";

    var labelIngredient = document.createElement("label");
    labelIngredient.textContent = "Zutat";

    var inputQuantity = document.createElement("input");
    inputQuantity.type = "ingredients";
    inputQuantity.classList.add("form-control");
    inputQuantity.classList.add("mt-2");
    inputQuantity.name = "quantityValue[]";
    inputQuantity.placeholder = "Menge";

    var labelQuantity = document.createElement("label");
    labelQuantity.textContent = "Menge";

    var quantityDiv = document.createElement("div");
    quantityDiv.classList.add("form-floating");
    quantityDiv.classList.add("mt-2");

    var selectQuantity = document.createElement("select");
    selectQuantity.classList.add("form-select");
    selectQuantity.classList.add("mt-2");
    selectQuantity.name = "quantityID[]";

    var optionDefault = document.createElement("option");
    optionDefault.selected = true;
    optionDefault.textContent = "Mengen Art";

    var option1 = document.createElement("option");
    option1.value = "1";
    option1.textContent = "mg";

    var option2 = document.createElement("option");
    option2.value = "2";
    option2.textContent = "g";

    var option3 = document.createElement("option");
    option3.value = "3";
    option3.textContent = "kg";

    var option4 = document.createElement("option");
    option4.value = "4";
    option4.textContent = "ml";

    var option5 = document.createElement("option");
    option5.value = "5";
    option5.textContent = "l";

    var option6 = document.createElement("option");
    option6.value = "6";
    option6.textContent = "Stück";

    var option7 = document.createElement("option");
    option7.value = "7";
    option7.textContent = "Esslöffel";

    var option8 = document.createElement("option");
    option8.value = "8";
    option8.textContent = "Teelöffel";

    selectQuantity.appendChild(optionDefault);
    selectQuantity.appendChild(option1);
    selectQuantity.appendChild(option2);
    selectQuantity.appendChild(option3);
    selectQuantity.appendChild(option4);
    selectQuantity.appendChild(option5);
    selectQuantity.appendChild(option6);
    selectQuantity.appendChild(option7);
    selectQuantity.appendChild(option8);

    IngredientDiv.appendChild(inputIngredient);
    IngredientDiv.appendChild(labelIngredient);
    quantityDiv.appendChild(inputQuantity);
    quantityDiv.appendChild(labelQuantity);

    container.appendChild(IngredientDiv);
    container.appendChild(selectQuantity);
    container.appendChild(quantityDiv);
  }
</script>
</body>
</html>