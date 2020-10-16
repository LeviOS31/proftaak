<?php
session_start();
if($_SESSION["loggedin"] != true){
    header("location:inloggen.php");
    echo "u bent niet ingelogged <a href='inloggen.php'>terug</a>";
}
$mysqli = new mysqli("localhost", "root", "root", "bezoekers_registratie");
    if ($mysqli->connect_error){
        echo "error kan niet connecten";
    }
$stmt = $mysqli -> prepare("UPDATE bezoekerspas SET in_gebruik = 'nee' WHERE nummer = ?;");
$stmt -> bind_param("s", $_GET["id"]);
if($stmt->execute() === true){
    header("location: homepage.php");
}
