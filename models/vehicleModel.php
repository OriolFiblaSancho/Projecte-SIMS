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

        // Neteja les dades
        $data['license_plate'] = htmlspecialchars(strip_tags($data['license_plate']));
        $data['model'] = htmlspecialchars(strip_tags($data['model']));
        $data['vehicle_type_id'] = htmlspecialchars(strip_tags($data['vehicle_type_id']));
        $data['battery_level'] = htmlspecialchars(strip_tags($data['battery_level']));
        $data['current_range'] = htmlspecialchars(strip_tags($data['current_range']));
        $data['total_km'] = htmlspecialchars(strip_tags($data['total_km']));
        $data['status'] = htmlspecialchars(strip_tags($data['status']));

        // Vincula els paràmetres
        $stmt->bindParam(':license_plate', $data['license_plate']);
        $stmt->bindParam(':model', $data['model']);
        $stmt->bindParam(':vehicle_type_id', $data['vehicle_type_id']);
        $stmt->bindParam(':battery_level', $data['battery_level']);
        $stmt->bindParam(':current_range', $data['current_range']);
        $stmt->bindParam(':total_km', $data['total_km']);
        $stmt->bindParam(':status', $data['status']);   

        $stmt->execute($data);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

}

?>