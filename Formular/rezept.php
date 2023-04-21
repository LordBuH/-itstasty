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

## DB Connection Data ##
$db_server = "localhost";
$db_user = "root";
$db_user_passwort = "";
$db_name = "itstasty";

## Mysql Connection ##
$database = mysqli_connect($db_server , $db_user, $db_user_passwort, $db_name);

## Check if Database Connection is Valid ##
if($database == false)
{
    exit;
}

$UserID = 1;

###### Rezept Insert ########
$Name = $_POST['Name'];
$Instruction = $_POST['Instruction'];
$Time = $_POST['Time'];
$RecipeImg = $_POST['RecipeImg'];

$sql_statment = "INSERT INTO `Recipe` (`UserID`, `Name`,`Instruction`, `Time`, `RecipeImg`) VALUES ('$UserID','$Name', '$Instruction', '$Time', '$RecipeImg')";

### Execute Mysql Statment ###
$con = mysqli_query($database, $sql_statment);

###### Zutaten Rezept DB ########
$IngredientsID = '1';
$RecipeID = $_POST['RecipeID'];
$QuantityID = $_POST['QuantityID'];
$QuantityValue = $_POST['QuantityValue'];

$sql_statment = "INSERT INTO `IngredientsRecipe` (`IngredientsID`, `RecipeID`, `QuantityID`, `QuantityValue`) VALUES('$IngredientsID', '$RecipeID', '$QuantityID', '$QuantityValue')";

$con = mysqli_query($database, $sql_statment);
echo'Daten wurden in die DB übertragen.';
?>
</body>
</html>