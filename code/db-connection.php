<?php
// Connexion à la base de données
    $servername = "localhost";
    $usernameDB = "root";
    $passwordDB = "";
    $dbname = "event_management";

    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
?>
