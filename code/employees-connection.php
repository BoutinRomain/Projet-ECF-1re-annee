<?php
session_start();
require_once 'db-connection.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Requête non autorisée.";
    } else {
        $prenom = htmlspecialchars(trim($_POST['family-name']));
        $nom = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT employeeid, password FROM employees WHERE email = ? AND family_name = ? AND name = ?");
        $stmt->bind_param("sss", $email, $prenom, $nom);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($employee_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['employee_id'] = $employee_id;
                $_SESSION['employeename'] = $prenom . ' ' . $nom;
                header('Location: employees.php');
                exit;
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Utilisateur non trouvé.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Connexion</h2>

            <?php if ($error) { ?>
                <p class="error message"><?php echo $error; ?></p>
            <?php } ?>

            <form action="employees-connection.php" method="POST">

                <div class="input-group">
                    <label for="family-name">Nom :</label>
                    <input type="text" id="family-name" name="family-name" required>
                </div>

                <div class="input-group">
                    <label for="name">Prénom :</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="input-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="input-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>