<?php session_start() ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
</head>
<body>
<form id="inlog" method="post" action="ingelogd.php">
    <h2>Inloggen</h2>
    <input type="text" name="naam" placeholder="Naam"><br>
    <input type="password" name="wachtwoord" placeholder="Wachtwoord"><br>
    <input type="submit" value="inloggen">
</form>
</body>
</html>
