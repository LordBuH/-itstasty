<?php

include 'db_conn.php';
if (isset($_POST['submit'])) { // Überprüfen, ob das Formular abgeschickt wurde
    $UserID = 1;
    $Name = $_POST['Name'];
    $Instruction = $_POST['Instruction'];
    $Time = $_POST['Time'];
    $RecipeImg = $_POST['RecipeImg'];

###### Rezept Insert ########
echo $Name;
$stmt = $conn->prepare('INSERT INTO Recipe (UserID, Name, Instruction, Time, RecipeImg) VALUES (?, ?, ?, ?, ?)');
$stmt->bind_param('sssss', $UserID, $Name, $Instruction, $Time, $RecipeImg);
$stmt->execute();

#$sql_statment = "INSERT INTO `RezeptTB` (`UserID`, `Name`,`Instruction`, `Time`, `RecipeImg`) VALUES ('$UserID','$Name', '$Instruction', '$Time', '$RecipeImg');"

### Execute Mysql Statment ###
#$con = mysqli_query($database, $sql_statment);

###### Zutaten Rezept DB ########
$IngredientsID = 1;
$RecipeID = $_POST['RecipeID'];
$QuantityID = $_POST['QuantityID'];
$QuantityValue = $_POST['QuantityValue'];

#$sql_statment = "INSERT INTO `ZutatenRezeptTB` (`IngredientsID`, `RecipeID`, `QuantityID`, `QuantityValue`) VALUES('$IngredientsID', '$RecipeID', '$QuantityID', '$QuantityValue')"
$stmt = $conn->prepare('INSERT INTO ingredientsrecipe (IngredientsID, RecipeID, QuantityID, QuantityValue) VALUES(?, ?, ?, ?)');
$stmt->bind_param('ssss', $IngredientsID, $RecipeID, $QuantityID, $QuantityValue);
$stmt->execute();

#$con = mysqli_query($database, $sql_statment)

}

$conn->close();
?>