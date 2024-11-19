<?php
session_start();
session_unset();
session_destroy(); // Détruit toutes les données de session
header("Location: home.php"); // Redirige vers la page de connexion
exit();
?>