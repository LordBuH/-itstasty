<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "itstasty";


// Verbindung herstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Prüfen, ob die Verbindung hergestellt wurde
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}
?>