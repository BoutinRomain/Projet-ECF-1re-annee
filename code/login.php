<?php
require_once "db-connection.php";
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

if (isset($_SESSION['logged_in'])) {
    header("Location: home.php");
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password) && !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
    } else {
        $sql = "SELECT userid, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;

                header("Location: home.php");
                exit();
            } else {
                $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect.";
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

            <form action="login.php" method="POST">

                <div class="input-group">
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" required>
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