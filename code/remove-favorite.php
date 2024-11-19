<?php
session_start();
include 'db-connection.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM favorites WHERE userid = ? AND eventid = ?");
    $stmt->bind_param("ii", $userId, $eventId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Favori supprimé avec succès.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Favori introuvable.']);
}

$stmt->close();
$conn->close();
?>