<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ItsTastY</title>
</head>
<body>
    <?php
                $headline = "Neues Rezept anlegen";
                echo'<h1>' . $headline . '</h1>';
                echo"    <form action='recipe.php' method='POST'>                        
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
                                 <input placeholder='Bild' name='RecipeImg'>
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

                            <input type='submit' name='submit' value='Anmelden'>
                        </form>
                    ";
    ?>
<form method="POST" action="index.php">
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

</script>

<?php
if(isset($_POST['zutaten'])) {
  var_dump($_POST['zutaten']);

  //foreach isset post zutaten als zutat
  // zutat insert table zutat für das rezept
}

?>

</body>
</html>
                    

            

