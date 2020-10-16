<?php
error_reporting(0);
session_start();
if($_SESSION["loggedin"] != true){
    header("location:inloggen.php");
    echo "u bent niet ingelogged <a href='inloggen.php'>terug</a>";
}

$bezoekersid = $_GET["id"];
$gebruiker = [];

$mysqli = new mysqli("localhost", "root", "root", "bezoekers_registratie");

    if ($mysqli->connect_error){
        echo "error kan niet connecten";
    }
$stmt = $mysqli -> query("SELECT naam, idbezoekers, bezoekerspas_idberzoekerspas FROM bezoekers WHERE idbezoekers = " . $bezoekersid . ";");
if($stmt -> num_rows > 0){
    while ($row = $stmt -> fetch_array(MYSQLI_ASSOC)){
        $stmt->close();
        $gebruiker[] = $row; // Eerst de data opslaan.
        $bezoekerspasid = $row["bezoekerspas_idberzoekerspas"];
    }
}else{
    echo "<p>er is een error met de database</p>" . $mysqli->error . "<br><br>";
}
foreach($gebruiker as $row){
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
function vertrektijdtoevoegen($mysqli, $bezoekersid, $bezoekerspasid){
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $stmt = $mysqli ->prepare("UPDATE bezoekers SET vertrek = ? WHERE idbezoekers = ?;");
        $stmt -> bind_param("ss", $_POST["vertrektijd"], $bezoekersid);
        if ($stmt->execute() === true) {
            $stmt2 = $mysqli -> prepare("UPDATE bezoekerspas SET in_gebruik = 'nee' WHERE nummer = ?;");
            $stmt2 -> bind_param("s", $bezoekerspasid);
            if($stmt2->execute() === true){
                header("location: homepage.php");
            }
        } else {
            echo "er is een error " . $mysqli->error;
        }
    }
}
vertrektijdtoevoegen($mysqli, $bezoekersid, $bezoekerspasid)
?>