<?php
session_start();
$error = '';
require_once '../db-connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $family_name = $_POST['family-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas. Veuillez réessayer.";
        header("Location: sign-in.php");
        exit();
    }

    // Vérifier la sécurité du mot de passe
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/';
    if (!preg_match($passwordRegex, $password)) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères, incluant des chiffres et des lettres majuscules et minuscules.";
        header("Location: sign-in.php");
        exit();
    }

    // Hacher le mot de passe avant de l'insérer dans la base de données
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparer l'insertion dans la table Users
    $stmt = $conn->prepare("INSERT INTO Employees (name, family_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $family_name, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: employee-gestion.php");
        exit();
    } else {
        $_SESSION['error'] = "Une erreur s'est produite lors de la création de votre compte.";
        header("Location: sign-in.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>