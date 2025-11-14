<?php
    require_once __DIR__ . '/../config/database.php';

    class Location {
        private $db;
        private $table = 'locations';
        private $location_id;
        private $vehicle_id;
        private $latitude;
        private $longitude;
        private $datetime;
        private $deleted;

        public function __construct() {
            $this->db = Database::getInstance()->getConnection();
        }


        public function create($data) {
            $query = "INSERT INTO " . $this->table . " (vehicle_id, latitude, longitude, datetime, deleted) 
                      VALUES (:vehicle_id, :latitude, :longitude, :datetime, false)";
            $stmt = $this->db->prepare($query);

            // Neteja les dades
            $data['vehicle_id'] = htmlspecialchars(strip_tags($data['vehicle_id']));
            $data['latitude'] = htmlspecialchars(strip_tags($data['latitude']));
            $data['longitude'] = htmlspecialchars(strip_tags($data['longitude']));
            $data['datetime'] = htmlspecialchars(strip_tags($data['datetime']));

            // Vincula els paràmetres
            $stmt->bindParam(':vehicle_id', $data['vehicle_id']);
            $stmt->bindParam(':latitude', $data['latitude']);
            $stmt->bindParam(':longitude', $data['longitude']);
            $stmt->bindParam(':datetime', $data['datetime']);

            return $stmt->execute();
        }

        public function getByVehicleId($vehicle_id) {
            $query = "SELECT * FROM " . $this->table . " WHERE vehicle_id = :vehicle_id AND deleted = false";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':vehicle_id', $vehicle_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getLatestByVehicleId($vehicle_id) {
            $query = "SELECT * FROM " . $this->table . " WHERE vehicle_id = :vehicle_id AND deleted = false ORDER BY datetime DESC LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':vehicle_id', $vehicle_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getLocationsCount() {
            $query = "SELECT COUNT(*) as cnt FROM " . $this->table . " WHERE deleted = false";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($row['cnt'] ?? 0);
        }

    }