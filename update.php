<?php

use leviconnect\MysqlConnection;

error_reporting(0);
session_start();
require_once("dbconnectionclass.php");
if ($_SESSION["loggedin"] != true) {
    header("location:inloggen.php");
    echo "u bent niet ingelogged <a href='inloggen.php'>terug</a>";
}

$bezoekersid = $_GET["id"];
$gebruiker = [];

$mysqli = new MysqlConnection;

if ($mysqli->connect_error) {
    echo "error kan niet connecten";
}
$stmt = $mysqli->connect()->query("SELECT naam, idbezoekers, bezoekerspas_idberzoekerspas FROM bezoekers WHERE idbezoekers = " . $bezoekersid . ";");
if ($stmt->num_rows > 0) {
    while ($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
        $stmt->close();
        $gebruiker[] = $row; // Eerst de data opslaan.
        $bezoekerspasid = $row["bezoekerspas_idberzoekerspas"];
    }
} else {
    echo "<p>er is een error met de database</p>" . $mysqli->error . "<br><br>";
}
foreach ($gebruiker as $row) {
    echo "<h2>" . $row["idbezoekers"] . " " . $row["naam"] . "</h2>";
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>bezoekers</title>
    </head>
    <body>
    <form action="" method="post">
        <p>vertrek tijd toevoegen Jaar/Maand/Dag/uur/min</p>
        <input type="text" name="vertrektijd" placeholder="vertrek tijd">
        <input type="submit" value="toevoegen">
    </form>
    <a href="homepage.php">terug</a>
    </body>
    </html>
<?php
require_once("updatefunction.php");
try {
    vertrektijdtoevoegen($bezoekersid, $bezoekerspasid);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>