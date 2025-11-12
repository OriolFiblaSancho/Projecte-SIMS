<?php

require_once __DIR__ . '/../config/database.php';

class GeofencingConfig {
    private $db;
    // Properties for each column
    public $zone_id;
    public $zone_name;
    public $center_latitude;
    public $center_longitude;
    public $radius_meters;
    public $max_speed_allowed;
    public $type;
    public $deleted;

    public function __construct($data = []) {
        $this->db = Database::getInstance()->getConnection();
        // Optionally initialize properties from $data
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getAllZones() {
        $query = "SELECT * FROM geofencing_config WHERE deleted = false";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM geofencing_config WHERE zone_id = :id AND deleted = false";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Populate object properties
            foreach ($row as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
        return $row;
    }

    public function create($data) {
        $query = "INSERT INTO geofencing_config (zone_name, center_latitude, center_longitude, radius_meters, max_speed_allowed, type, deleted) 
                  VALUES (:zone_name, :center_latitude, :center_longitude, :radius_meters, :max_speed_allowed, :type, false)";
        $stmt = $this->db->prepare($query);

        // Neteja les dades
        $data['zone_name'] = htmlspecialchars(strip_tags($data['zone_name']));
        $data['type'] = htmlspecialchars(strip_tags($data['type']));

        $stmt->bindParam(':zone_name', $data['zone_name']);
        $stmt->bindParam(':center_latitude', $data['center_latitude']);
        $stmt->bindParam(':center_longitude', $data['center_longitude']);
        $stmt->bindParam(':radius_meters', $data['radius_meters']);
        $stmt->bindParam(':max_speed_allowed', $data['max_speed_allowed']);
        $stmt->bindParam(':type', $data['type']);

        if ($stmt->execute()) {
            // Populate object properties after insert
            $this->zone_id = $this->db->lastInsertId();
            $this->zone_name = $data['zone_name'];
            $this->center_latitude = $data['center_latitude'];
            $this->center_longitude = $data['center_longitude'];
            $this->radius_meters = $data['radius_meters'];
            $this->max_speed_allowed = $data['max_speed_allowed'];
            $this->type = $data['type'];
            $this->deleted = false;
            return $this->zone_id;
        }
        return false;
    }

    /**
     * Update a zone by id
     */
    public function update($id, $data) {
        $query = "UPDATE geofencing_config SET zone_name = :zone_name, center_latitude = :center_latitude, center_longitude = :center_longitude, radius_meters = :radius_meters, max_speed_allowed = :max_speed_allowed, type = :type WHERE zone_id = :id";
        $stmt = $this->db->prepare($query);

        $data['zone_name'] = htmlspecialchars(strip_tags($data['zone_name']));
        $data['type'] = htmlspecialchars(strip_tags($data['type']));

        $stmt->bindParam(':zone_name', $data['zone_name']);
        $stmt->bindParam(':center_latitude', $data['center_latitude']);
        $stmt->bindParam(':center_longitude', $data['center_longitude']);
        $stmt->bindParam(':radius_meters', $data['radius_meters']);
        $stmt->bindParam(':max_speed_allowed', $data['max_speed_allowed']);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    /**
     * Soft delete a zone by setting deleted = true
     */
    public function softDelete($id) {
        $query = "UPDATE geofencing_config SET deleted = true WHERE zone_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

?>