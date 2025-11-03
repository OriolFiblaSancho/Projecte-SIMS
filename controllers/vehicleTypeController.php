<?php
require_once __DIR__ . '/../models/vehicleTypeModel.php';
require_once __DIR__ . '/../config/router.php';

class VehicleTypeController {
    private $vehicleTypeModel;

    public function __construct() {
        $this->vehicleTypeModel = new VehicleType();
    }

    public function getAll() {
        $vehicleTypes = $this->vehicleTypeModel->getAllVehiclesTypes();
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Vehicles/VehiclesForm.php';
    }

}

?>