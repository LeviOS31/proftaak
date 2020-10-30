<?php
session_start();
if ($_SESSION["loggedin"] != true) {
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
    <form action="toevoegenfunction.php" method="post">
        <h2>bezoeker inschrijven</h2>
        <p>tijd invullen als: jaar/maand/dag/uur/min</p>
        <input type="text" name="naam" placeholder="naam">
        <input type="text" name="bedrijf" placeholder="bedrijf">
        <input type="text" name="aankomst" placeholder="aankomst tijd">
        <input type="number" name="nummerbzpas" placeholder="nummer bezoekerspas">
        <input type="submit" value="toevoegen">
    </form>
    <a href="homepage.php">terug</a>
    </body>
    </html>
<?php

?>