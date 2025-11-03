<?php
// --- CONFIGURACIÓN DE SALIDA Y ERRORES ---
ini_set('display_errors', 0); // Evita imprimir HTML en errores
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

require_once '/models/geofencingModel.php';

try {
    $geofencing = new GeofencingConfig();
    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($method) {

        /**
         * GET → obtener todas las zonas o una específica por ID
         * Ejemplo: GET /GeofencingController.php?id=3
         */
        case 'GET':
            if (isset($_GET['id'])) {
                $zone = $geofencing->getZoneById($_GET['id']);
                if ($zone) {
                    echo json_encode(['success' => true, 'data' => $zone]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Zone not found.']);
                }
            } else {
                $zones = $geofencing->all();
                echo json_encode(['success' => true, 'data' => $zones]);
            }
            break;

        /**
         * POST → crear nueva zona
         */
        case 'POST':
            $required = ['zone_name', 'center_latitude', 'center_longitude', 'radius_meters', 'max_speed_allowed', 'type'];
            foreach ($required as $field) {
                if (!isset($input[$field])) {
                    echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
                    exit;
                }
            }

            $response = $geofencing->createZone(
                $input['zone_name'],
                $input['center_latitude'],
                $input['center_longitude'],
                $input['radius_meters'],
                $input['max_speed_allowed'],
                $input['type']
            );

            echo json_encode($response);
            break;

        /**
         * PUT → actualizar zona existente
         * Ejemplo: PUT /GeofencingController.php?id=2
         */
        case 'PUT':
            if (!isset($_GET['id'])) {
                echo json_encode(['success' => false, 'message' => 'Zone ID required.']);
                exit;
            }
            if (!$input || !is_array($input)) {
                echo json_encode(['success' => false, 'message' => 'Invalid or empty body.']);
                exit;
            }

            $success = $geofencing->updateZone($_GET['id'], $input);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Zone updated successfully.' : 'Error updating zone.'
            ]);
            break;

        /**
         * DELETE → eliminación lógica (soft delete)
         * Ejemplo: DELETE /GeofencingController.php?id=5
         */
        case 'DELETE':
            if (!isset($_GET['id'])) {
                echo json_encode(['success' => false, 'message' => 'Zone ID required.']);
                exit;
            }

            $success = $geofencing->deleteZone($_GET['id']);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Zone deleted successfully.' : 'Error deleting zone.'
            ]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Unsupported HTTP method.']);
            break;
    }
} catch (Exception $e) {
    // --- Captura cualquier error interno ---
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred.',
        'error' => $e->getMessage()
    ]);
}
