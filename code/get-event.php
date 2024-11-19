<?php
session_start();
include 'db-connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = (int)$_GET['id'];
    
    $stmt = $conn->prepare("SELECT name, description, nb_of_participant, start_date, duration_minutes, image_path, isvisible FROM events WHERE eventid = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        echo json_encode(['success' => true, 'name' => $event['name'], 'description' => $event['description'], 'nb_of_participants' => $event['nb_of_participant'], 'start_date' => date("d/m/Y H:i", strtotime($event['start_date'])), 'duration_minutes' => $event['duration_minutes'], 'image_path' => $event['image_path'], 'isvisible' => $event['isvisible']]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>