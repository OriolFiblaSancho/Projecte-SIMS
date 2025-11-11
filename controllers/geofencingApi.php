<?php
// Simple API endpoint that returns geofencing zones as JSON
require_once __DIR__ . '/../models/geofencingModel.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $model = new GeofencingConfig();
    $zones = $model->getAllZones();
    echo json_encode($zones);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

exit;
