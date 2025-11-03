<?php
require_once 'BaseModel.php';

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

        $data = [
            'zone_name' => $zone_name,
            'center_latitude' => $center_latitude,
            'center_longitude' => $center_longitude,
            'radius_meters' => $radius_meters,
            'max_speed_allowed' => $max_speed_allowed,
            'type' => $type,
            'deleted' => false
        ];

        if ($this->create($data)) {
            return ['success' => true, 'message' => 'Zone created successfully.'];
        }

        return ['success' => false, 'message' => 'Error creating zone.'];
    }

    // Obtener una zona por ID
    public function getZoneById($id) {
        return $this->find($id, 'zone_id');
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
