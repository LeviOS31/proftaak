<?php
session_start();
$info = [];
function inloggen(){
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $naam = htmlspecialchars($_POST["naam"]);
        $password = htmlspecialchars($_POST["wachtwoord"]);
        if (!empty($name) || !empty($password)){
            $mysqli = new mysqli("localhost", "root", "root", "bezoekers_registratie");
            if ($mysqli->connect_error){
                echo "error kan niet connecten";
            }else{
                $stmt = $mysqli ->prepare("select idreceptionist from receptionist where naam=? and wachtwoord=?;");
                $stmt -> bind_param("ss", $naam, $password);
                $stmt -> execute();
                $result = $stmt -> get_result();
                if ($result->num_rows > 0){
                    $_SESSION["loggedin"] = true;
                    $_SESSION["naam"] = $naam;
                    header ("location:homepage.php");
                }else {
                    die ("Je hebt geen geldige combinatie van naam en wachtwoord<br>
                <a href=\"inloggen.php\">Opnieuw inloggen</a>");
                }
            }
        }else{
            header("Location: inloggen.php");
        }

    }else{
        header("Location:inloggen.php");
    }
}
inloggen();