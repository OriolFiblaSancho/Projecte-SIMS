<?php 
    require_once __DIR__ . '/../models/locationModel.php';
    require_once __DIR__ . '/../config/router.php';
    
    class LocationController {
        private $locationModel;

        public function __construct() {
            $this->locationModel = new Location();
        }

        public function create() {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                return;
            }

            $data = json_decode(file_get_contents('php://input'), true);

            $result = $this->locationModel->create($data);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Location saved successfully.'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Error saving location.'
                ]);
            }
        }

        public function getByVehicleId($vehicle_id) {
            $locations = $this->locationModel->getByVehicleId($vehicle_id);
            echo json_encode($locations);
        }
    }