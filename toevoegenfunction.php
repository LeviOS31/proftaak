<?php
function toevoegen($naam, $bedrijf, $aankomst, $nummerbzpas)
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

            echo "er is een error " . $mysqli->error;

        }

    } else {

        echo "er is een error " . $mysqli->error;

    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!empty($_POST["naam"]) || !empty($_POST["bedrijf"]) || !empty($_POST["aankomst"]) || !empty($_POST["nummerbzpas"])) {

        $naam = $_POST["naam"];
        $bedrijf = $_POST["bedrijf"];
        $aankomst = $_POST["aankomst"];
        $nummerbzpas = $_POST["nummerbzpas"];

        toevoegen($naam, $bedrijf, $aankomst, $nummerbzpas);
    }
}
