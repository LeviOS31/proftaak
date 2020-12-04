<?php
declare(strict_types = 1);

use leviconnect\MysqlConnection;

function toevoegen(string $naam, string $bedrijf, string $aankomst, int $nummerbzpas)
{
    $mysqli = new mysqli("localhost", "root", "root", "bezoekers_registratie");
    if ($mysqli->connect_error) {
        echo "error kan niet connecten";
    }

    $stmt = $mysqli->prepare("INSERT INTO `bezoekers` (`idbezoekers`, `naam`, `bedrijf`, `aankomst`, `vertrek`, `bezoekerspas_idberzoekerspas`, `idReceptionist`) VALUES (NULL, ?, ?, ?, NULL, ?, 1);");
    $stmt->bind_param("ssss", $naam, $bedrijf, $aankomst, $nummerbzpas);
    if ($stmt->execute() === true) {

        $stmt2 = $mysqli->prepare("UPDATE bezoekerspas SET in_gebruik = 'ja' WHERE nummer = ?;");
        $stmt2->bind_param("s", $nummerbzpas);
        if ($stmt2->execute() === true) {

            header("Location: homepage.php");

        } else {
            throw new Exception("2 er is een error " . $mysqli->error);
        }
    } else {
        throw new Exception("1 er is een error " . $mysqli->error);
        echo $mysqli->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST["naam"]) || !empty($_POST["bedrijf"]) || !empty($_POST["aankomst"]) || !empty($_POST["nummerbzpas"])) {

        $naam = $_POST["naam"];
        $bedrijf = $_POST["bedrijf"];
        $aankomst = $_POST["aankomst"];
        $nummerbzpas = intval($_POST["nummerbzpas"]);

        try {
            toevoegen($naam, $bedrijf, $aankomst, $nummerbzpas);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
