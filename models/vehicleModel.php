<?php

require_once __DIR__ . '/../config/database.php';

class Vehicle {
    private $db;
    private $table = 'vehicles';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllVehicles($limit = 5, $offset = 0) {
        $query = "SELECT 
                    v.*,
                    l.latitude,
                    l.longitude,
                    l.datetime as location_datetime
                  FROM " . $this->table . " v
                  LEFT JOIN (
                    SELECT vehicle_id, latitude, longitude, datetime,
                           ROW_NUMBER() OVER (PARTITION BY vehicle_id ORDER BY datetime DESC) as rn
                    FROM locations
                    WHERE deleted = false
                  ) l ON v.vehicle_id = l.vehicle_id AND l.rn = 1
                  WHERE v.deleted = false LIMIT :limit OFFSET :offset;";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVehiclesCount() {
        $query = "SELECT COUNT(*) as cnt FROM " . $this->table . " WHERE deleted = false";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($row['cnt']);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE vehicle_id = :id AND deleted = false";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (license_plate, model, vehicle_type_id, battery_level, current_range, total_km, status, deleted) 
                  VALUES (:license_plate, :model, :vehicle_type_id, :battery_level, :current_range, :total_km, :status, false)";
        $stmt = $this->db->prepare($query);

        $data['battery_level'] = 0;
        $data['current_range'] = 0;

        // Neteja les dades
        $data['license_plate'] = htmlspecialchars(strip_tags($data['license_plate']));
        $data['model'] = htmlspecialchars(strip_tags($data['model']));
        $data['vehicle_type_id'] = htmlspecialchars(strip_tags($data['vehicle_type_id']));
        $data['status'] = htmlspecialchars(strip_tags($data['status']));
        $data['total_km'] = htmlspecialchars(strip_tags($data['total_km']));
        
        // Vincula els paràmetres
        $stmt->bindParam(':license_plate', $data['license_plate']);
        $stmt->bindParam(':model', $data['model']);
        $stmt->bindParam(':vehicle_type_id', $data['vehicle_type_id']);
        $stmt->bindParam(':battery_level', $data['battery_level']);
        $stmt->bindParam(':current_range', $data['current_range']);
        $stmt->bindParam(':total_km', $data['total_km']);
        $stmt->bindParam(':status', $data['status']);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET license_plate = :license_plate, model = :model, vehicle_type_id = :vehicle_type_id, total_km = :total_km, status = :status WHERE vehicle_id = :id";
        $stmt = $this->db->prepare($query);

        // Neteja les dades
        $data['license_plate'] = htmlspecialchars(strip_tags($data['license_plate']));
        $data['model'] = htmlspecialchars(strip_tags($data['model']));
        $data['vehicle_type_id'] = htmlspecialchars(strip_tags($data['vehicle_type_id']));
        $data['status'] = htmlspecialchars(strip_tags($data['status']));
        $data['total_km'] = htmlspecialchars(strip_tags($data['total_km']));

        $stmt->bindParam(':license_plate', $data['license_plate']);
        $stmt->bindParam(':model', $data['model']);
        $stmt->bindParam(':vehicle_type_id', $data['vehicle_type_id']);
        $stmt->bindParam(':total_km', $data['total_km']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "UPDATE " . $this->table . " SET deleted = true WHERE vehicle_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

?>