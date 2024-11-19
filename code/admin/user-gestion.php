<?php
require_once '../db-connection.php';

$query = "SELECT userid, username, email FROM users";
$users = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="list.css">
</head>
<body>
    <h1>Gestion des Utilisateurs</h1>
    <a href="admin.php" class="button">Retour</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pseudo</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['userid']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <button class="delete-button" onclick="suppressUser(<?php echo htmlspecialchars($user['userid']); ?>)">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
<script>
    function suppressUser(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
            console.log(JSON.stringify({ id: id }));
            
            fetch('delete-user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json().then(err => {
                        throw new Error(err.message);
                    });
                }
            })
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur de réseau ou de connexion.');
            });
        }
    }
</script>
</html>