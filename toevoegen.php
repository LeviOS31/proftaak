<?php
    session_start();
    if($_SESSION["loggedin"] != true){
        header("location:inloggen.php");
        echo "u bent niet ingelogged <a href='inloggen.php'>terug</a>";
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <title>bezoekers</title>
    </head>
    <body>
        <form action="" method="post">
            <h2>bezoeker inschrijven</h2>
            <p>tijd invullen als: jaar/maand/dag/uur/min</p>
            <input type = "text" name = "naam" placeholder = "naam">
            <input type = "text" name = "bedrijf" placeholder = "bedrijf">
            <input type = "text" name = "aankomst" placeholder = "aankomst tijd">
            <input type = "text" name = "nummerbzpas" placeholder = "nummer bezoekerspas">
            <input type = "submit" value = "toevoegen">
        </form>
        <a href="homepage.php">terug</a>
    </body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST"){

    if(!empty($_POST["naam"]) || !empty($_POST["bedrijf"]) || !empty($_POST["aankomst"]) || !empty($_POST["nummerbzpas"])){
        
        $naam = $_POST["naam"];
        $bedrijf = $_POST["bedrijf"];
        $aankomst = $_POST["aankomst"];
        $nummerbzpas = $_POST["nummerbzpas"];

        $mysqli = new mysqli("localhost", "root", "root", "bezoekers_registratie");
        if ($mysqli->connect_error){
            echo "error kan niet connecten";
        }

        $stmt = $mysqli->prepare("INSERT INTO `bezoekers` (`idbezoekers`, `naam`, `bedrijf`, `aankomst`, `vertrek`, `bezoekerspas_idberzoekerspas`, `idReceptionist`) VALUES (NULL, ?, ?, ?, NULL, ?, 1);");
        $stmt -> bind_param("ssss", $naam, $bedrijf, $aankomst, $nummerbzpas);
        if($stmt -> execute() === true){

            $stmt2 = $mysqli->prepare("UPDATE bezoekerspas SET in_gebruik = 'ja' WHERE nummer = ?;");
            $stmt2 -> bind_param( "s", $nummerbzpas);
            if($stmt2 -> execute() === true){

                header("Location: homepage.php");

            }else{

                echo "er is een error " . $mysqli->error;

            }

        }else{

            echo "er is een error " . $mysqli->error;

        }

        
    }
}
?>