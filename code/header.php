<!-- header.php -->
<?php
session_start();
?>
<div class="top-row">
    <img src="pictures/Society_logo.png" alt="Logo de la société">
    <h1 class="txt-center white">Esportify Événementiel E-SPORTS</h1>
    <ul class="prevent-ul side-item fancy">
        <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
            <!-- Si l'utilisateur n'est pas connecté, afficher les boutons "Sign In" et "Log In" -->
            <li><a href="sign-in.php">Sign In</a></li>
            <li><a href="login.php">Log In</a></li>
        <?php else: ?>
            <!-- Si l'utilisateur est connecté, afficher le bouton "Log Out" -->
            <li><a href="logout.php">Log Out</a></li>
        <?php endif; ?>
    </ul>
</div>
<nav class="navigation">
    <ul class="prevent-ul fancy">
        <li><a href="home.php">Accueil</a></li>
        <li><a href="event.php">Événements</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php if (isset($_SESSION['logged_in'])): ?>
            <li><a href="profil.php">Profil</a></li>
        <?php endif; ?>
    </ul>
</nav>