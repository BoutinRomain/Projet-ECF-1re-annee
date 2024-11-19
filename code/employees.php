<?php
session_start();
require_once 'db-connection.php';

if (!isset($_SESSION['employee_id'])) {
    header('Location: employees-connection.php');
    exit;
}

$query = "SELECT name, nb_of_participant, start_date, duration_minutes, image_path, isvisible, eventid FROM events";
$events = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link rel="stylesheet" href="css/event.css">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="stylesheet" href="admin/admin.css">
    <link rel="stylesheet" href="admin/list.css">
</head>
<body>
    <header class="admin-header">
        <h1>Gestion des événements</h1>
    </header>
    <a class="button"><?php echo $_SESSION['employeename']?></a>
    <a href="employees-logout.php" class="button">Log out</a>
    <div class="event-list"><?php
        if (isset($events)) :
            foreach ($events as $event) :
                $class = $event['isvisible'] ? "" : 'not-visible'?>
            <div class="event <?php echo $class; ?>" onclick="openEvent(<?php echo htmlspecialchars($event['eventid']); ?>)">
                <?php
                echo "Nom: " . htmlspecialchars($event['name']) . "<br>";
                echo "Nombre de Participants: " . htmlspecialchars($event['nb_of_participant']) . "<br>";
                echo "Date de Début: " . htmlspecialchars($event['start_date']) . "<br>";
                echo "Durée : " . htmlspecialchars($event['duration_minutes']) . " minutes<br><br>";
                ?>
                <img class="image" src="<?php echo htmlspecialchars($event['image_path']) ?>" alt="image de l'événement">
            </div>
            <?php endforeach; 
        endif; ?>
    </div>
    <div id="event-popup" class="background-overlay hidden" onclick="closeEvent()">
        <div class="container" id='container'>
            <div class="form-box">
                <h2 id="event-name"></h2>
                <p id="event-description"></p>
                <p><strong>Participants:</strong> <span id="event-participants"></span></p>
                <p><strong>Date de début:</strong> <span id="event-start-date"></span></p>
                <p><strong>Durée:</strong> <span id="event-duration"></span> minutes</p>
                <img id="event-image" src="" alt="Event Image" class="image">
                <button type="button" onclick="" id="visibility-button">Rendre visible</button><br><br>
                <button type="button" onclick="" id="suppress-button">Supprimer</button>
            </div>
        </div>
    </div>
</body>
<script>
    function openEvent(eventid) {
        fetch('get-event.php?id=' + eventid)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('event-name').textContent = data.name;
                    document.getElementById('event-description').textContent = data.description;
                    document.getElementById('event-participants').textContent = data.nb_of_participants;
                    document.getElementById('event-start-date').textContent = data.start_date;
                    document.getElementById('event-duration').textContent = data.duration_minutes;
                    document.getElementById('event-image').src = data.image_path;
                    
                    if (data.isvisible) {
                        document.getElementById('container').classList.remove('not-visible')
                        document.getElementById('visibility-button').textContent = "Rendre invisible"
                    } else {
                        document.getElementById('container').classList.add('not-visible')
                        document.getElementById('visibility-button').textContent = "Rendre visible"
                    }
                    document.getElementById('visibility-button').setAttribute('onclick', 'visibility('+eventid+', '+data.isvisible+')');
                    document.getElementById('suppress-button').setAttribute('onclick', 'suppressEvent('+eventid+')');
                    document.getElementById('suppress-button').textContent = "Supprimer l'événements"
                    document.getElementById('event-popup').classList.remove('hidden');
                } else {
                    alert('Événement introuvable.');
                }
            })
            .catch(error => console.error("Erreur lors de la récupération de l'événement : ", error));
    }
    
    function closeEvent() {
        document.getElementById('event-popup').classList.add('hidden');
    }

    function suppressEvent(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet événement ?")) {
            console.log(JSON.stringify({ id: id }));
            
            fetch('admin/delete-event.php', {
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

    function visibility(id, visible) {
        event.stopPropagation();

        fetch('admin/update-visibility.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ eventid: id, isvisible: visible ? 0 : 1 })
        })
        .then(response => response.text())
        .then(data => {
            location.reload();
        })
    }
</script>
</html>