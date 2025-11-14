<?php
require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../models/vehicleModel.php';
require_once __DIR__ . '/../models/geofencingModel.php';

class DashboardController {
    public function index() {
        try {
            $userModel = new UserModel();
            $vehicleModel = new Vehicle();
            $geofencingModel = new GeofencingConfig();

            $data = [
                'totalUsers' => $userModel->getUsersCount(),
                'totalVehicles' => $vehicleModel->getVehiclesCount(),
                'totalZones' => $geofencingModel->getZonesCount(),
                'totalBalance' => $userModel->getTotalBalance(),
                'verifiedUsers' => $userModel->getVerifiedUsersCount(),
                'availableVehicles' => $vehicleModel->getAvailableVehiclesCount(),
                'usersByMonth' => $userModel->getUsersByMonth(),
            ];
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }

        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Dashboard/Dashboard.php';
    }
}
?>