<?php

require_once __DIR__ . '/../config/database.php';

class VehicleType {
    private $db;
    private $table = 'vehicle_types';
    private $type_id;
    private $name;
    private $description;
    private $range_km;
    private $max_speed;
    private $adapted_reduced_mobility;
    private $deleted;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllVehiclesTypes() {
        $query = "SELECT * FROM " . $this->table . " WHERE deleted = false";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id AND deleted = 0";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>