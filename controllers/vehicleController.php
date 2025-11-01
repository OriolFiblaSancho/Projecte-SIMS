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

}

?>