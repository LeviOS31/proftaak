<?php
session_start();
unset ($_SESSION["loggedin"]);
unset ($_SESSION["naam"]);
session_destroy();
header ("location: inloggen.php");
