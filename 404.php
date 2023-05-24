<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 - Seite nicht gefunden</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
    crossorigin="anonymous"></script></head>
</head>
<body>
  <h1>404 - Seite nicht gefunden!</h1>
  <p>Es tut uns leid, aber die von Ihnen angeforderte Seite konnte nicht gefunden werden.</p>
</body>
</html>



<?php
  include 'db_conn.php';
  include 'content.php';
  session_start();
        if(isset($_SESSION['userID'])){
            $userID = $_SESSION['userID'];
            $username = $_SESSION['username'];
            $userImg = $_SESSION['userImg'];
       }
       else{
        header('Location: login.php');
       }
?>
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
      <input type="username" class="form-control" id="floatingInput" name="name" placeholder="Name">
      <label for="floatingname">Name</label>
    </div>       
    <div class="form-floating">
      <input type="instruction" class="form-control" id="floatingInput" name='time' placeholder='Zeit'>
      <label for="floatingtime">Zeit</label>
    </div>    

    <div class="form-floating">
      <input  type='file' id='floatingInput' name='recipeImg' accept='image/jpeg'>
    </div>



    <div class="form-floating">
      <input type="instruction" class="form-control" id="floatingInput" name='instruction' placeholder='Zubereitung'>
      <label for="floatinginstruction">Zutaten</label>
    </div> 
    <div class="form-floating">
    <div class="btn-group shadow-0">
      <select class="form-select" name='quantityID' aria-label="Default select example">
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
    <div class="form-floating">
      <input type="instruction" class="form-control" id="floatingInput" name='quantityValue' placeholder='Menge'>
      <label for="floatingquantityValue">Menge</label>
    </div>  


    <div class="d-grid gap-2">
      <button class="btn btn-light btn-lg" type="submit"  name="submit" value="Hochladen">Hochladen</button>
    </div>
  <?php
    if (isset($error)) { 
      echo"<p>$error</p>";
    } 
  ?>
    </div>
  </div>
</div>
</div>
 <?php /*
                $headline = "Neues Rezept anlegen";
                echo'<h1>' . $headline . '</h1>';
                echo"    <form action='addrecipe.php' method='POST'>                        
                            <div class='inputs'>
                                <input placeholder='Name' name='Name'>
                            </div>
                            <div class='inputs'>
                                 <input placeholder='Zubereitung' name='Instruction'>
                            </div>                            
                            <div class='inputs'>
                                <input placeholder='Zeit' name='Time'>
                            </div>
                            <div class='inputs'>
                                <input  type='file' id='floatingInput' name='RecipeImg' accept='image/jpeg'>
                            </div>                            
                            <p>RezeptID Wichtig vortlaufende Zahlen eintragen. Der erster Eintrag 1 und dann weiter zählen xD.</p>   
                            <div class='inputs'>
                                 <input placeholder='RezeptID' name='RecipeID'>
                            </div>                    
                            <p>1 = mg, 2 = g, 3 = kg, 4 = ml, 5 = l, 5 = Stück, 6 = Esslöffel, 7 = Teelöffel</p>       
                            <div class='inputs'>
                                <input placeholder='MengenBezeichnungID' name='QuantityID'>
                            </div>
                            <div class='inputs'>
                                 <input placeholder='Menge' name='QuantityValue'>
                            </div>

                            <input type='submit' name='submit' value='Rezept hochladen'>
                        </form>
                    "; 
   */ ?>
<!--<form method="POST" action="addrecipe.php">
  <div id="input-felder">
    <input type="text" name="zutaten[]" placeholder="Zutat" />
  </div>

  <div id="more">+</div>
  <br />
  <br />
  <br />
  <br />
  <br />
  <input type="submit" value="submit" />
</form>
<script>

const button = document.getElementById("more");
const container = document.getElementById("input-felder");

button.addEventListener('click', () => {
  const input = document.createElement('input');
  input.setAttribute('name', 'zutaten[]');
  input.setAttribute('type', 'text');
  input.setAttribute('placeholder', 'Zutat');

  container.append(input);
})

</script>-->

<?php
/*
if(isset($_POST['zutaten'])) {
  var_dump($_POST['zutaten']);

  //foreach isset post zutaten als zutat
  // zutat insert table zutat für das rezept
}

if (isset($_POST['submit'])) { // Überprüfen, ob das Formular abgeschickt wurde
    $name = $_POST['name'];
    $instruction = $_POST['instruction'];
    $time = $_POST['time'];
    $recipeImg = $_POST['recipeImg'];

###### Rezept Insert ########
echo 'Rezept wurde erfolgreich in die DB geladen.';
$stmt = $conn->prepare('INSERT INTO Recipe (UserID, Name, Instruction, Time, RecipeImg) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param('sssss', $userID, $name, $instruction, $time, $recipeImg);
$stmt->execute();


###### Zutaten Rezept DB ########
$IngredientsID = 1;
$RecipeID = $_POST['recipeID'];
$QuantityID = $_POST['quantityID'];
$QuantityValue = $_POST['quantityValue'];

#$sql_statment = "INSERT INTO `ZutatenRezeptTB` (`IngredientsID`, `RecipeID`, `QuantityID`, `QuantityValue`) VALUES('$IngredientsID', '$RecipeID', '$QuantityID', '$QuantityValue')"
$stmt = $conn->prepare('INSERT INTO ingredientsrecipe (IngredientsID, RecipeID, QuantityID, QuantityValue) VALUES(?, ?, ?, ?)');
$stmt->bind_param('ssss', $IngredientsID, $RecipeID, $QuantityID, $QuantityValue);
$stmt->execute();

}

$conn->close();
?>*/

  GetFooter();
?>
</body>
</html>