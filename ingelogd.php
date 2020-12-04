<?php
declare(strict_types = 1);
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // start the session
    session_start();
    // Retrieve the login data:
    $username = $_POST["naam"];
    $login_password = $_POST["wachtwoord"];
    // Set the default values for the database (unsafe):
    $host = 'localhost';
    $db   = 'bezoekers_registratie';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        // Create a database connection
        $pdo = new PDO($dsn, $user, $pass, $options);
        // Get the hash_code for this user:
        $stmt = $pdo->prepare("SELECT wachtwoord FROM receptionist WHERE naam = ?");
        $stmt->execute([$username]);
        $arr = $stmt->fetch();
        $hash_code = $arr["wachtwoord"];
        // An empty array is returned if there are zero results to fetch, or FALSE on failure.
        if ($hash_code === false) {
            // Invalid login
            throw new PDOException('deze gebruiker bestaat niet <a href="../pages/login.html">ga terug</a>');
        } else {
            // check the hash_code
            if (!password_verify($login_password, $hash_code)) {
                // Invalid login
                throw new PDOException('dit is een fout wachtwoord <a href="../pages/login.html">ga terug</a>');
            } else {
                // valid login
                // store session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['naam'] = $username;
                // redirect to the user menu
                header("location:homepage.php");
            }
        }
    } catch (PDOException $e) {
        // Give an error message:
        echo $e->getMessage();
    }
}