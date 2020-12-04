<?php
declare(strict_types = 1);


function vertrektijdtoevoegen( string $bezoekersid, string $bezoekerspasid)
{
    $mysqli = new mysqli("localhost", "root", "root", "bezoekers_registratie");
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $stmt = $mysqli->prepare("UPDATE bezoekers SET vertrek = ? WHERE idbezoekers = ?;");
        $stmt->bind_param("ss", $_POST["vertrektijd"], $bezoekersid);
        if ($stmt->execute() === true) {
            $stmt2 = $mysqli->prepare("UPDATE bezoekerspas SET in_gebruik = 'nee' WHERE nummer = ?;");
            $stmt2->bind_param("s", $bezoekerspasid);
            if ($stmt2->execute() === true) {
                header("location: homepage.php");
            }
        } else {
            throw new Exception("er is een error $mysqli->error");
        }
    }
}


