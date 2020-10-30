<?php
session_start();
if ($_SESSION["loggedin"] != true) {
    header("location:inloggen.php");
    echo "u bent niet ingelogged <a href='inloggen.php'>terug</a>";
} else {
    $mysqli = new mysqli("localhost", "root", "root", "bezoekers_registratie");
    if ($mysqli->connect_error) {
        echo "error kan niet connecten";
    }

    // Maak een leeg array aan om de medewerkers in op te slaan:
    $bezoeker = [];

    $mysqli_resultaat = $mysqli->query("SELECT idbezoekers, naam, bedrijf, aankomst, vertrek FROM bezoekers ORDER BY aankomst DESC, idbezoekers DESC;");
    if ($mysqli_resultaat->num_rows > 0) {
        while ($row = $mysqli_resultaat->fetch_array(MYSQLI_ASSOC)) {
            $bezoeker[] = $row; // Eerst de data opslaan.
        }
    }
    // Sluit het resultaat af
    $mysqli_resultaat->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>bezoekers</title>
</head>
<body>
<h2>welkom <?php echo $_SESSION["naam"]; ?></h2>
<h3>bezoekers</h3>
<?php
echo '<table border="2px solid black" style="border-collapse:collapse">';
echo "<tr><td>id</td><td>naam</td><td>bedrijf</td><td>aankomst</td><td>vertrek</td></tr>";
foreach ($bezoeker as $row) { //inhoud table
    echo "<tr><td>" . $row["idbezoekers"] . "</td><td>" . $row["naam"] . "</td><td>" . $row["bedrijf"] . "</td><td>" . $row["aankomst"] . "</td><td>" . $row["vertrek"] . "</td><td>" . "<a href='update.php?id=" . $row["idbezoekers"] . "'>vertrek toevoegen</a>" . "</td></tr>";
}
echo "</table>";
?>
<br><a href="toevoegen.php">Bezoeker toevoegen</a><br><br>
<h3>bezoekerspas</h3>
<?php
$bezoekerspas = [];
function bezoekerstonen($mysqli)
{
    $stmt = $mysqli->query("SELECT nummer, in_gebruik FROM bezoekerspas ORDER BY in_gebruik ASC;");
    if ($stmt->num_rows > 0) {
        while ($rows = $stmt->fetch_array(MYSQLI_ASSOC)) {
            $bezoekerspas[] = $rows;
        }
    } else {
        throw new Exception("er is een error $mysqli->error");
    }
    echo '<table border="2px solid black" style="border-collapse:collapse">';
    echo "<tr><td>nummer</td><td>in gebruik</td></tr>";
    foreach ($bezoekerspas as $rows) { //inhoud table
        echo "<tr><td>" . $rows["nummer"] . "</td><td>" . $rows["in_gebruik"] . "</td></tr>";
    }
    echo "</table>";
}

try {
    bezoekerstonen($mysqli);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
<br><a href="uitloggen.php">uitloggen</a>
</body>
</html>
