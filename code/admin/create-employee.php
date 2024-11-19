<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/popup.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Créer un compte employé</h2>

            <?php if ($error) { ?>
                <p class="error message"><?php echo $error; ?></p>
            <?php } ?>

            <form action="employee-register.php" method="POST" onsubmit="return validatePassword();">

                <div class="input-group">
                    <label for="name">Prénom</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="input-group">
                    <label for="family-name">Nom</label>
                    <input type="text" id="family-name" name="family-name" required>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="input-group">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="input-group">
                    <button type="submit">Créer</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    //Vérifacation avant l'envoie du formulaire
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;

            if (password !== confirmPassword) {
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }

            if (!passwordRegex.test(password)) {
                alert("Le mot de passe doit contenir au moins 8 caractères, incluant des chiffres et des lettres majuscules et minuscules.");
                return false;
            }

            return true;
        }
    </script>
</html>