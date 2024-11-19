<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/body-style.css">
</head>
<body>
    <header id="header"></header>
    <main class="contact-container">
        <h2>Contactez-nous</h2>
        <p>Pour toute question ou information complémentaire, n'hésitez pas à nous contacter en remplissant le formulaire ci-dessous.</p>
        
        <form action="submit-contact.php" method="POST" class="contact-form">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </main>

    <script src="header.js"></script>
    <script src="footer.js"></script>
</body>
</html>