<?php
session_start();
require 'db-connection.php';

$sql = "SELECT e.eventid, e.name, e.nb_of_participant, e.start_date, e.duration_minutes, e.image_path, COUNT(f.userid) AS favorite_count
FROM events e
LEFT JOIN favorites f ON e.eventid = f.eventid
WHERE e.isvisible = true
GROUP BY e.eventid
ORDER BY favorite_count DESC, e.start_date ASC, e.name ASC
LIMIT 4";

$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/square-title.css">
    <link rel="stylesheet" href="css/event.css">
    <link rel="stylesheet" href="css/body-style.css">
</head>
<body>
    <header id="header"></header>
    <div class="news">
        <div class="news-txt">
            <h2>A propos de nous</h2>
            <p>Nous somme une entreprise Française d'organisation d'événement E-sports fondé le 17 mars 2021. Lors de la création de notre société nous avions un objectif en tête: les événements e-sport à porté de main! C'est donc dans cet optique que nous avons ouvert notre site. Nos serveur pourrons héberger en direct vos événements que vous pourrez rejoindre depuis chez vous.<br>Nous vous souhaitons de bonnes séance E-sports.</p>
        </div>
        <div class="img-diapo">
            <button class="arrow left-arrow">&lt;</button>
            <img class="responsive-img" src="pictures/place_holder.png" alt="place_holder, cause i don't have pictures">
            <button class="arrow right-arrow">&gt;</button>
        </div>
    </div>
    <h2 class="tt-sq">Les plus attendus</h2>
    <div class="event-list">
        <?php if ($result && $result->num_rows > 0) :
            foreach ($result as $event) : ?>
                <div class="event">
                    <?php
                    echo "Nombre de Favoris: " . htmlspecialchars($event['favorite_count']) . "<br><br>";
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
    <script src="header.js"></script>
    <script src="footer.js"></script>
</body>
</html>