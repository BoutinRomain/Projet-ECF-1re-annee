<?php
session_start();
include 'db-connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit;
}

$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$eventId = $data['eventid'];


if (!$eventId || !$userId) {
    echo json_encode(['success' => false, 'message' => 'Paramètres incorrects']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM favorites WHERE userid = ? AND eventid = ?");
$stmt->bind_param("ii", $userId, $eventId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'exists']);
} else {
    $stmt = $conn->prepare("INSERT INTO favorites (userid, eventid) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $eventId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'insertion']);
    }
}

$stmt->close();
$conn->close();
?>