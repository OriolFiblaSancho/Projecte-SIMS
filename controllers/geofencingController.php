<?php
require_once __DIR__ . '/../models/geofencingModel.php';
require_once __DIR__ . '/../config/router.php';

class GeofencingController {
    private $model;

    public function __construct() {
        $this->model = new GeofencingConfig();
    }

    public function getAll() {
        $zones = $this->model->getAllZones();
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Geofencing/GeofencingTable.php';
    }

    public function create(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            return;
        }

        $errors = $this->validateZone($_POST);
        
        if (empty($errors)) {
            $result = $this->model->create($_POST);

            if ($result) {
                $_SESSION['success'] = "Zona creada correctament!";
                Router::redirect('/geofencing');
            } else {
                $_SESSION['error'] = "Error creant la zona";
            }
        } else {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
        }

        Router::redirect('/geofencing/create');
    }

    private function validateZone($data) {
        $errors = [];

        if (empty($data['zone_name'])) {
            $errors['zone_name'] = "El nom de la zona és obligatori.";
        }
        if (!isset($data['center_latitude']) || !is_numeric($data['center_latitude'])) {
            $errors['center_latitude'] = "La latitud ha de ser un número.";
        }
        if (!isset($data['center_longitude']) || !is_numeric($data['center_longitude'])) {
            $errors['center_longitude'] = "La longitud ha de ser un número.";
        }
        if (!isset($data['radius_meters']) || !is_numeric($data['radius_meters']) || $data['radius_meters'] <= 0) {
            $errors['radius_meters'] = "El radi ha de ser major que 0.";
        }
        if (!isset($data['max_speed_allowed']) || !is_numeric($data['max_speed_allowed'])) {
            $errors['max_speed_allowed'] = "La velocitat màxima ha de ser un número.";
        }
        $allowedTypes = ['school','hospital','historic_center','residential_area'];
        if (empty($data['type']) || !in_array($data['type'], $allowedTypes)) {
            $errors['type'] = "Tipus de zona no vàlid.";
        }
        return $errors;
    }
}
?>