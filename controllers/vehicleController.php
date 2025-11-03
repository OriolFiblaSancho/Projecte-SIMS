<?php
require_once __DIR__ . '/../models/vehicleModel.php';
require_once __DIR__ . '/../config/router.php';

class VehicleController {
    private $vehicleModel;

    public function __construct() {
        $this->vehicleModel = new Vehicle();
    }

    public function getAll() {
        $vehicles = $this->vehicleModel->getAllVehicles();
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Vehicles/VehiclesTable.php';
    }

    public function create(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            return;
        }

        $result = $this->vehicleModel->create($_POST);

        if ($result) {
            $_SESSION['success'] = "Vehicle created successfully!";
            Router::redirect('/main?admin=ViewVehicles');
        } else {
            $_SESSION['error'] = "Error creating vehicle";
             Router::redirect('/main?admin=FormVehicles');
        }
    
    }

    private function validateVehicle($data) {
        $errors = [];

        if (empty($data['license_plate'])) {
            $errors['license_plate'] = "License plate is required.";
        }

        if (empty($data['model'])) {
            $errors['model'] = "Model is required.";
        }

        if (empty($data['vehicle_type_id']) || !is_numeric($data['vehicle_type_id'])) {
            $errors['vehicle_type_id'] = "Valid vehicle type is required.";
        }

        if (!isset($data['battery_level']) || !is_numeric($data['battery_level']) || $data['battery_level'] < 0 || $data['battery_level'] > 100) {
            $errors['battery_level'] = "Battery level must be a number between 0 and 100.";
        }

        if (!isset($data['current_range']) || !is_numeric($data['current_range']) || $data['current_range'] < 0) {
            $errors['current_range'] = "Current range must be a non-negative number.";
        }

        if (!isset($data['total_km']) || !is_numeric($data['total_km']) || $data['total_km'] < 0) {
            $errors['total_km'] = "Total kilometers must be a non-negative number.";
        }

        if (empty($data['status'])) {
            $errors['status'] = "Status is required.";
        }

        return $errors;
    }

}

?>