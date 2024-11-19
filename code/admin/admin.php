<?php
require_once '../db-connection.php';

$query = "
    SELECT 
        DATE(DATE_ADD(CURDATE(), INTERVAL n DAY)) AS event_day,
        COALESCE(COUNT(e.start_date), 0) AS event_count
    FROM (
        SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
        UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14
        UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19
        UNION SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24
        UNION SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29
        UNION SELECT 30
    ) AS days
    LEFT JOIN events e ON DATE(e.start_date) = DATE_ADD(CURDATE(), INTERVAL n DAY)
    WHERE DATE_ADD(CURDATE(), INTERVAL n DAY) BETWEEN CURDATE() AND LAST_DAY(CURDATE() + INTERVAL 1 MONTH)
    GROUP BY event_day
    ORDER BY event_day;
";

$result = $conn->query($query);
$eventDays = [];
$eventCounts = [];

foreach ($result as $row) {
    $eventDays[] = $row['event_day'];
    $eventCounts[] = $row['event_count'];
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Admin</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <header class="admin-header">
        <h1>Espace admin</h1>
    </header>

    <div class="admin-grid">
        <div class="admin-card" onclick="employee()">
            <p>Créer / gérer employées</p>
        </div>

        <div class="admin-card">
            <canvas id="eventChart" width="400" height="200"></canvas>
        </div>

        <div class="admin-card" onclick="user()">
            <p>Gérer utilisateurs</p>
        </div>

        <div class="admin-card" onclick="event_window()">
            <p>Gérer événements</p>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('eventChart').getContext('2d');
        const eventDays = <?php echo json_encode($eventDays); ?>;
        const eventCounts = <?php echo json_encode($eventCounts); ?>;

        const eventChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: eventDays,
                datasets: [{
                    label: 'Nombre d\'événements',
                    data: eventCounts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nombre d\'événements'
                        },
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        }
                    }
                }
            }
        });

        function employee() {
            window.location.assign("employee-gestion.php");
        }

        function user() {
            window.location.assign("user-gestion.php");
        }

        function event_window() {
            window.location.assign("event-gestion.php");
        }
    </script>
</body>
</html>
