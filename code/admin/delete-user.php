<?php
require_once '../db-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = isset($data['id']) ? $data['id'] : null;
    error_log("data : ". $id."\n");

    if ($id) {

        error_log("ID à supprimer : " . $id);
        $stmt = $conn->prepare("DELETE FROM users WHERE userid = ?");
        if ($stmt === false) {
            error_log("Erreur de préparation de la requête : " . $conn->error);
            http_response_code(500);
            echo json_encode(['message' => 'Erreur lors de la préparation de la requête']);
            exit;
        }
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(['message' => 'Utilisateur supprimé avec succès']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Erreur lors de la suppression de l\'utilisateur']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'ID d\'utilisateur non fourni']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Méthode non autorisée']);
}
?>