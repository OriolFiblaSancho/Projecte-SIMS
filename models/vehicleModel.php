<?php

require_once __DIR__ . '/../config/database.php';

class Vehicle {
    private $db;
    private $table = 'vehicles';
    private $id;
    private $license_plate;
    private $model;
    private $vehicle_type_id;
    private $battery_level;
    private $current_range;
    private $total_km;
    private $status;
    private $deleted;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllVehicles() {
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

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (license_plate, model, vehicle_type_id, battery_level, current_range, total_km, status, deleted) 
                  VALUES (:license_plate, :model, :vehicle_type_id, :battery_level, :current_range, :total_km, :status, 0)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

}

?>