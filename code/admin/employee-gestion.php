<?php
require_once '../db-connection.php';

$query = "SELECT employeeid, name, family_name, email FROM employees";
$employees = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés</title>
    <link rel="stylesheet" href="list.css">
</head>
<body>
    <h1>Gestion des Employés</h1>
    <a href="create-employee.php" class="button">Créer un Employé</a>
    <a href="admin.php" class="button">Retour</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee['employeeid']); ?></td>
                    <td><?php echo htmlspecialchars($employee['name']); ?></td>
                    <td><?php echo htmlspecialchars($employee['family_name']); ?></td>
                    <td><?php echo htmlspecialchars($employee['email']); ?></td>
                    <td>
                        <button class="delete-button" onclick="suppressEmployee(<?php echo htmlspecialchars($employee['employeeid']); ?>)">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
<script>
    function suppressEmployee(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet employé ?")) {
            console.log(JSON.stringify({ id: id }));
            
            fetch('delete-employee.php', {
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