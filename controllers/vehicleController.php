<?php
require_once __DIR__ . '/../models/vehicleModel.php';
require_once __DIR__ . '/../config/router.php';
require_once __DIR__ . '/../models/vehicleTypeModel.php';
require_once __DIR__ . '/../models/locationModel.php';
class VehicleController {
    private $vehicleModel;
    private $vehicleTypeModel;

    public function __construct() {
        $this->vehicleModel = new Vehicle();
        $this->vehicleTypeModel = new VehicleType();
    }

    public function getAll() {
        $limit = 7;
        $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

        $totalVehicles = $this->vehicleModel->getVehiclesCount();
        
        $maxOffset = 0;
        if ($totalVehicles > 0) {
            $pages = (int) ceil($totalVehicles / $limit);
            $maxOffset = max(0, ($pages - 1) * $limit);
        }

        if ($offset > $maxOffset) {
            $offset = $maxOffset;
        }

        // Align offset to page size so offset always refers to page boundaries
        if ($limit > 0) {
            $offset = (int) floor($offset / $limit) * $limit;
        }

        // expose step to view so pagination component can use same step
        $step = $limit;

        $vehicles = $this->vehicleModel->getAllVehicles($limit, $offset );
        $vehicleTypes = $this->vehicleTypeModel->getAllVehiclesTypes();
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Vehicles/VehiclesTable.php';
    }

    public function create(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            return;
        }

        // Create the vehicle first
        $newVehicleId = $this->vehicleModel->create($_POST);

        if ($newVehicleId) {
            // If latitude and longitude were provided, create a location record
            $lat = $_POST['latitude'] ?? null;
            $lng = $_POST['longitude'] ?? null;

            if (!empty($lat) && !empty($lng)) {
                $locationModel = new Location();
                $locationData = [
                    'vehicle_id' => $newVehicleId,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'datetime' => date('Y-m-d H:i:s')
                ];
                $locationModel->create($locationData);
            }

            $_SESSION['success'] = "Vehicle created successfully!";
            Router::redirect('/main?admin=ViewVehicles');
        } else {
            $_SESSION['error'] = "Error creating vehicle";
            Router::redirect('/main?admin=FormVehicles');
        }
    
    }
    public function delete() {
        $id = $_GET['id'];
        
        if (!$id){
            Router::redirect('/main?admin=ViewVehicles');
        }
    
        $result = $this->vehicleModel->delete($id);

        if ($result) {
            $_SESSION['success'] = "Vehicle deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting vehicle";
        }
        Router::redirect('/main?admin=ViewVehicles');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        $id = $_POST['vehicle_id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Vehicle id missing.';
            Router::redirect('/main?admin=ViewVehicles');
        }

        $success = $this->vehicleModel->update($id, $_POST);

        if ($success) {
            // If latitude and longitude provided, create a new location entry
            $lat = $_POST['latitude'] ?? null;
            $lng = $_POST['longitude'] ?? null;
            if (!empty($lat) && !empty($lng)) {
                $locationModel = new Location();
                $locationModel->create([
                    'vehicle_id' => $id,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'datetime' => date('Y-m-d H:i:s')
                ]);
            }

            $_SESSION['success'] = 'Vehicle updated successfully.';
        } else {
            $_SESSION['error'] = 'Error updating vehicle.';
        }
        Router::redirect('/main?admin=ViewVehicles');
    }

    public function view($id) {
        $id = $_GET['id'] ?? null;
        

        if (!$id) {
            $_SESSION['error'] = "Vehicle ID not provided.";
            Router::redirect('/main?admin=ViewVehicles');
        }

        $vehicle = $this->vehicleModel->getById($id);
        if (!$vehicle) {
            $_SESSION['error'] = "Vehicle not found.";
            Router::redirect('/main?admin=ViewVehicles');
        }

        $vehicleTypes = $this->vehicleTypeModel->getAllVehiclesTypes();
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Vehicles/VehicleView.php';
    }

    public function getVehiclesWithLocations() {
        header('Content-Type: application/json');
        $vehicles = $this->vehicleModel->getAllVehicles();
        echo json_encode($vehicles);
        exit;
    }

}

?>