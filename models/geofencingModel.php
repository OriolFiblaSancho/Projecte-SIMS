<?php
require_once __DIR__ . '/baseModel.php';

class GeofencingConfig extends BaseModel {
    public function __construct() {
        parent::__construct('geofencing_config');
    }

    // Crear una nueva zona
    public function createZone($zone_name, $center_latitude, $center_longitude, $radius_meters, $max_speed_allowed, $type) {
        $allowedTypes = ['school', 'hospital', 'historic_center', 'residential_area'];
        if (!in_array($type, $allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid zone type.'];
        }

        // Omit `deleted` so the database default (false) is applied.
        $data = [
            'zone_name' => $zone_name,
            'center_latitude' => $center_latitude,
            'center_longitude' => $center_longitude,
            'radius_meters' => $radius_meters,
            'max_speed_allowed' => $max_speed_allowed,
            'type' => $type
        ];

        try {
            if ($this->create($data)) {
                return ['success' => true, 'message' => 'Zone created successfully.'];
            } else {
                $errorInfo = $this->pdo->errorInfo();
                return [
                    'success' => false,
                    'message' => 'Error creating zone.',
                    'errorInfo' => $errorInfo
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'PDOException: ' . $e->getMessage()
            ];
        }
    }

    // Obtener una zona por ID
        public function getZoneById($id) {
            return $this->findById($id, 'zone_id');
        }

    // Actualizar zona
    public function updateZone($zone_id, $data) {
        return $this->update($zone_id, $data, 'zone_id');
    }

    // Eliminación lógica
    public function deleteZone($zone_id) {
        return $this->softDelete($zone_id, 'zone_id');
    }
}
