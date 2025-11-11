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
        // If an edit id was provided, load the vehicle to prefill the form
        $vehicle = null;
        $editId = null;
        if (isset($_GET['edit'])) {
            $editId = intval($_GET['edit']);
        } elseif (isset($_GET['id'])) {
            $editId = intval($_GET['id']);
        }

        if ($editId && $editId > 0) {
            require_once __DIR__ . '/../models/vehicleModel.php';
            $vm = new Vehicle();
            $vehicle = $vm->getById($editId);
            // Try to load latest location for this vehicle and attach to $vehicle
            require_once __DIR__ . '/../models/locationModel.php';
            $lm = new Location();
            $loc = $lm->getLatestByVehicleId($editId);
            if ($loc) {
                $vehicle['latitude'] = $loc['latitude'];
                $vehicle['longitude'] = $loc['longitude'];
            }
        }
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Vehicles/VehiclesForm.php';
    }

}

?>