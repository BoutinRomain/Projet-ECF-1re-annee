<?php
session_start();
require 'db-connection.php';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
$success = isset($_SESSION['success']) ? $_SESSION['success'] : false;
unset($_SESSION['success']);
$max_file_size = 2;

if (!isset($_SESSION['logged_in'])) {
    header("Location: home.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT username, email FROM users WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$query_favorites = "SELECT eventid FROM favorites WHERE userid = ?";
$stmt_favorites = $conn->prepare($query_favorites);
$stmt_favorites->bind_param("i", $user_id);
$stmt_favorites->execute();
$result_favorites = $stmt_favorites->get_result();

$favorite_ids = [];
while ($row = $result_favorites->fetch_assoc()) {
    $favorite_ids[] = $row['eventid'];
}

$favorites = [];
if (!empty($favorite_ids)) {
    $ids_placeholder = implode(',', array_fill(0, count($favorite_ids), '?')); // Création de placeholder pour les requêtes préparées
    $query_events = "SELECT name, nb_of_participant, start_date, duration_minutes, image_path, eventid FROM events WHERE isvisible = 1 AND eventid IN ($ids_placeholder)";
    $stmt_events = $conn->prepare($query_events);
    $stmt_events->bind_param(str_repeat('i', count($favorite_ids)), ...$favorite_ids); // Liage des paramètres
    $stmt_events->execute();
    $result_events = $stmt_events->get_result();
    
    while ($row = $result_events->fetch_assoc()) {
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


if ($_SERVER["REQUEST_METHOD"] == "POST" && !$success) {
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE userid = ? AND username = ?");
        $stmt->bind_param("is", $_SESSION['user_id'], $_SESSION['username']);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Récupère les données du formulaire
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $nb_of_participants = isset($_POST['nb_of_participants']) ? (int)$_POST['nb_of_participants'] : null;
            $start_date = $_POST['start_date'] ?? '';
            $start_time = $_POST['start_time'] ?? '';
            $duration_minutes = isset($_POST['duration_minutes']) ? (int)$_POST['duration_minutes'] : null;

            // Vérifie que tous les champs sont remplis
            if (empty($name) || empty($description) || empty($nb_of_participants) || empty($start_date) || empty($start_time) || empty($duration_minutes)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
            } else {
                $start_date_time = $start_date . ' ' . $start_time;
                $image_path = "";

                // Vérifie et enregistre l'image téléchargée
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    if ($_FILES['image']['size'] <= $max_file_size * 1024 * 1024) {
                        $image_tmp_path = $_FILES['image']['tmp_name'];
                        $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $image_name = uniqid("event_", true) . '.' . $image_extension;
                        $image_path = 'uploads/' . $image_name;

                        // Déplace l'image vers le dossier "uploads"
                        if (!file_exists('uploads')) {
                            mkdir('uploads', 0777, true);
                        }
                        if (move_uploaded_file($image_tmp_path, $image_path)) {
                            $image_path = $conn->real_escape_string($image_path);
                        } else {
                            $_SESSION['error'] = "Échec du téléchargement de l'image.";
                        }
                    } else {
                        $_SESSION['error'] = "L'image est trop grande. La taille maximale est de $max_file_size Mo.";
                    }
                } else {
                    $_SESSION['error'] = "Veuillez télécharger une image.";
                }

                // Insère les données dans la base si aucune erreur
                if (empty($_SESSION['error'])) {
                    $sql = "INSERT INTO events (name, description, nb_of_participant, start_date, duration_minutes, image_path, creatorID) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssisisi", $name, $description, $nb_of_participants, $start_date_time, $duration_minutes, $image_path, $_SESSION['user_id']);

                    if ($stmt->execute()) {
                        $_SESSION['success'] = true;
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    } else {
                        $_SESSION['error'] = "Erreur lors de l'ajout de l'événement : " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
        } else {
            header("Location: logout.php");
            exit();
        }
    }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="stylesheet" href="css/profil.css">
    <link rel="stylesheet" href="css/square-title.css">
    <link rel="stylesheet" href="css/event.css">
    <link rel="stylesheet" href="css/body-style.css">
    <title>Event</title>
</head>
<body>
    <header id="header"></header>
    <div class="bar">
        <div class="box">
            <h3><?php echo htmlspecialchars($user['username']); ?></h3>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
        </div>
        <div class="box clicker" onclick="newEventPopup()">
            Créer un Événement
        </div>
    </div>
    <div>
        <h4 class="tt-sq">Vos Favoris</h4>
        <div class="event-list"><?php
        if (isset($events)) :
            foreach ($events as $event) :?>
            <div class="event" onclick="openEvent(<?php echo htmlspecialchars($event['id']); ?>)">
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
                <button type="button" onclick="" id="favorite-button">Supprimer des favoris</button>
            </div>
        </div>
    </div>
    <div class="background-overlay" id="eventPopup" style="display:none">
        <div class="container">
            <div class="form-box">
                <h2>Ajouter un Nouvel Événement</h2>
                <?php if ($error) { ?>
                    <p class="error message"><?php echo $error; ?></p>
                <?php } if ($success) { ?>
                    <p class="success message"><?php echo "success"; ?></p>
                    <a href="profil.php">
                        <button type="button">Retour</button>
                    </a>
                <?php } else { ?>
                    <form action="profil.php" method="POST" enctype="multipart/form-data">

                        <label for="name">Nom de l'événement :</label>
                        <input type="text" id="name" name="name" required style="width: 95%">

                        <label for="description">Description :</label>
                        <textarea id="description" name="description" required></textarea>

                        <label for="nb_of_participants">Nombre de participants :</label>
                        <input type="number" id="nb_of_participants" name="nb_of_participants" required>

                        <label for="start_date">Date de début :</label>
                        <input type="date" id="start_date" name="start_date" required>

                        <label for="start_time">Heure de début :</label>
                        <input type="time" id="start_time" name="start_time" required>

                        <label for="duration_minutes">Durée (en minutes) :</label>
                        <input type="number" id="duration_minutes" name="duration_minutes" required>

                        <label for="image">Image de l'événement :</label>
                        <input type="file" id="image" name="image" accept="image/*" required><br><br>

                        <button type="submit">Ajouter l'Événement</button><br><br>
                        <button type="button" onclick="closePopup()">Retour</button>
                    </form>                
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="header.js"></script>
    <script src="footer.js"></script>
    <script>
        function newEventPopup() {
            document.getElementById("eventPopup").style.display = "block";
        };
        function closePopup() {
            document.getElementById("eventPopup").style.display = "none";
        }
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

                        document.getElementById('favorite-button').setAttribute('onclick', 'removeFavorite('+eventid+')');
                        document.getElementById('favorite-button').textContent = 'Supprimer des favoris'
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

        function removeFavorite(eventid) {
            event.stopPropagation()
            fetch('remove-favorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ eventid: eventid })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('favorite-button').textContent = "L'événement a été supprimé de vos favoris !";
                    location.reload();
                } else {
                    document.getElementById('favorite-button').textContent = "Erreur lors de la suppression des favoris : " + data.message;
                }
            })
            .catch(error => console.error("Erreur : ", error));
        }
    </script>
</body>
</html>