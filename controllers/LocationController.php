<?php 
    require_once __DIR__ . '/../models/locationModel.php';
    require_once __DIR__ . '/../config/router.php';
    require_once __DIR__ . '/../helpers/i18n.php';
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
                    'message' => t('location_saved')
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => t('error_saving_location')
                ]);
            }
        }

        public function getByVehicleId($vehicle_id) {
            $locations = $this->locationModel->getByVehicleId($vehicle_id);
            echo json_encode($locations);
        }
    }