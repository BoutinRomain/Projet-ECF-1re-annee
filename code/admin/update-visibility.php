<?php
require_once '../db-connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$eventid = $data['eventid'];
$isvisible = $data['isvisible'];

if (isset($eventid) && isset($isvisible)) {
    $stmt = $conn->prepare("UPDATE events SET isvisible = ? WHERE eventid = ?");
    $stmt->bind_param("ii", $isvisible, $eventid);

    if ($stmt->execute()) {
        echo "Visibilité mise à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Paramètres manquants.";
}

$conn->close();
?>
