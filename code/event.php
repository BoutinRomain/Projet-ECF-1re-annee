<?php
session_start();

require_once 'db-connection.php';

$query = "SELECT name, nb_of_participant, start_date, duration_minutes, image_path, eventid FROM events WHERE isvisible = 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $events = [];

    while ($row = $result->fetch_assoc()) {
        $startDateTime = new DateTime($row['start_date']);
        $formattedDate = $startDateTime->setTimezone(new DateTimeZone('Europe/Paris'))->format('d/m/Y H:i');

        $events[] = [
            'name' => $row['name'],
            'nb_of_participant' => $row['nb_of_participant'],
            'start_date' => $formattedDate,
            'duration_minutes' => $row['duration_minutes'],
            'image_path' => $row['image_path'],
            'id' => $row['eventid'],
        ];
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link rel="stylesheet" href="css/popup.css">
    <link rel="stylesheet" href="css/event.css">
    <link rel="stylesheet" href="css/body-style.css">
    <link rel="stylesheet" href="css/filter.css">
</head>
<body>
    <header id="header"></header>
    <div id="filters">
        <label for="minParticipants">Nombre minimum de participants :</label>
        <input type="number" id="minParticipants" min="0" placeholder="0">

        <label for="date">Date :</label>
        <input type="date" id="date">

        <label for="time">Heure :</label>
        <input type="time" id="time">

        <button onclick="filterEvents()">Filtrer</button>
    </div>
    <div class="event-list"><?php
        if (isset($events)) :
            foreach ($events as $event) :?>
            <div class="event" 
            onclick="openEvent(<?php echo htmlspecialchars($event['id']); ?>)" 
            data-participants="<?php echo htmlspecialchars($event['nb_of_participant']); ?>" 
            data-date="<?php echo htmlspecialchars(date('Y-d-m', strtotime($event['start_date']))); ?>" 
            data-time="<?php echo htmlspecialchars(date('H:i', strtotime($event['start_date']))); ?>">
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
        <div class="container">
            <div class="form-box">
                <h2 id="event-name"></h2>
                <p id="event-description"></p>
                <p><strong>Participants:</strong> <span id="event-participants"></span></p>
                <p><strong>Date de début:</strong> <span id="event-start-date"></span></p>
                <p><strong>Durée:</strong> <span id="event-duration"></span> minutes</p>
                <img id="event-image" src="" alt="Event Image" class="image">
                <button type="button" onclick="" id="favorite-button">Ajouter aux favoris</button>
            </div>
        </div>
    </div>
    <script src="header.js"></script>
    <script src="footer.js"></script>
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

                    document.getElementById('favorite-button').setAttribute('onclick', 'addToFavorites('+eventid+')');
                    document.getElementById('favorite-button').textContent = 'Ajouter aux favoris'
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

    function addToFavorites(eventid) {
        event.stopPropagation()
        fetch('add-favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ eventid: eventid })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('favorite-button').textContent = "L'événement a été ajouté aux favoris !";
            } else if (data.message === "exists") {
                document.getElementById('favorite-button').textContent = "L'événement est déjà dans vos favoris.";
            } else {
                document.getElementById('favorite-button').textContent = "Erreur lors de l'ajout aux favoris.";
            }
        })
        .catch(error => console.error("Erreur : ", error));
    }

    function filterEvents() {
        const minParticipants = parseInt(document.getElementById('minParticipants').value, 10) || 0;
        const selectedDate = document.getElementById('date').value;
        const selectedTime = document.getElementById('time').value;

        const events = document.querySelectorAll('.event');

        events.forEach(event => {
            const eventParticipants = parseInt(event.getAttribute('data-participants'), 10);
            const eventDate = event.getAttribute('data-date');
            const eventTime = event.getAttribute('data-time');
            console.log(selectedDate, eventDate)

            // Vérification des conditions de filtrage
            const meetsParticipants = eventParticipants >= minParticipants;
            
            // Applique les critères de date et heure uniquement s'ils sont spécifiés
            const meetsDate = selectedDate ? eventDate === selectedDate : true;
            const meetsTime = selectedTime ? eventTime === selectedTime : true;

            // Affiche ou cache l'événement
            if (meetsParticipants && meetsDate && meetsTime) {
                event.style.display = 'flex';
            } else {
                event.style.display = 'none';
            }
        });
    }
</script>
</body>
</html>