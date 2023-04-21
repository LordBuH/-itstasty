<?php
## DB Connection Data ##
$db_server = "localhost"
$db_user = "root"
$db_user_passwort = ""
$db_name = ""

## Mysql Connection ##
$database = mysqli_connect($db_server , $db_user, $db_user_passwort, $db_name);

## Check if Database Connection is Valid ##
if($database == false)
{
    exit;
}

$NutzerID = $_POST['NutzerID'];

###### Rezept Insert ########
$Name = $_POST['Name'];
$Zubereitung = $_POST['Zubereitung'];
$Zeit = $_POST['Zeit'];
$Bild = $_POST['Bild'];

$sql_statment = "INSERT INTO `RezeptTB` (`NutzerID`, `Name`,`Zubereitung`, `Zeit`, `Bild`) VALUES ('$NutzerID','$Name', '$Zubereitung', '$Zeit', '$Bild');"

### Execute Mysql Statment ###
$con = mysqli_query($database, $sql_statment);

###### Zutaten Rezept DB ########
$ZutatenID = $_POST['ZutatenID'];
$RezeptID = $_POST['RezeptID'];
$MengenBezeichnungID = $_POST['MengenBezeichnungID'];
$Menge = $_POST['Menge'];

$sql_statment = "INSERT INTO `ZutatenRezeptTB` (`ZutatenID`, `RezeptID`, `MengenBezeichnungID`, `Menge`) VALUES('$ZutatenID', '$RezeptID', '$MengenBezeichnungID', '$Menge')"

$con = mysqli_query($database, $sql_statment)

?>