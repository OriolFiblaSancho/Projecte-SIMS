<?php
require_once __DIR__ . '/../models/geofencingModel.php';
require_once __DIR__ . '/../config/router.php';

class GeofencingController {
    private $model;

    public function __construct() {
        $this->model = new GeofencingConfig();
    }

    // List zones (used by admin menu)
    public function getAll() {
        $limit = 7;
        $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

        $totalZones = $this->model->getZonesCount();
        $maxOffset = 0;
        if ($totalZones > 0) {
            $pages = (int) ceil($totalZones / $limit);
            $maxOffset = max(0, ($pages - 1) * $limit);
        }

        if ($offset > $maxOffset) {
            $offset = $maxOffset;
        }

        if ($limit > 0) {
            $offset = (int) floor($offset / $limit) * $limit;
        }

        $step = $limit;
        $zones = $this->model->getZonesPaginated($limit, $offset);
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Geofencing/GeofencingTable.php';
    }

    // Show create form (GET)
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // If form posts directly here, delegate to store
            return $this->store();
        }

        // Provide old/errors from session if available
        $old = $_SESSION['old'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['old'], $_SESSION['errors']);

        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Geofencing/GeofencingForm.php';
    }

    // Handle create form submission (POST)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::redirect('/geofencing/create');
        }

        $errors = $this->validateZone($_POST);
        if (empty($errors)) {
            $result = $this->model->create($_POST);
            if ($result) {
                $_SESSION['success'] = "Zona creada correctament!";
                Router::redirect('/main?admin=ViewGeofencing');
            } else {
                $_SESSION['error'] = "Error creant la zona";
                $_SESSION['old'] = $_POST;
            }
        } else {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
        }

        Router::redirect('/main?admin=geofencing/create');
    }

    // View a single zone
    public function view($id = null) {
        if (!$id) return;
        $zone = $this->model->getById($id);
        if (!$zone) {
            echo "Zona no trobada.";
            return;
        }
        $zoneData = $zone; // associative for view
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Geofencing/GeofencingView.php';
    }

    // Show edit form (GET) - reuse the same form component but populate $old
    public function edit($id = null) {
        if (!$id) return;
        $zone = $this->model->getById($id);
        if (!$zone) {
            echo "Zona no trobada.";
            return;
        }

        $old = $zone;
        $errors = [];
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Geofencing/GeofencingForm.php';
    }

    // Handle update (POST)
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::redirect('/main?admin=ViewGeofencing');
        }
        $id = $_POST['zone_id'] ?? null;
        if (!$id) {
            $_SESSION['error'] = 'Id de zona faltant.';
            Router::redirect('/main?admin=ViewGeofencing');
        }

        $errors = $this->validateZone($_POST);
        if (empty($errors)) {
            $ok = $this->model->update($id, $_POST);
            if ($ok) {
                $_SESSION['success'] = 'Zona actualitzada.';
            } else {
                $_SESSION['error'] = 'Error actualitzant la zona.';
            }
            Router::redirect('/main?admin=ViewGeofencing');
        }

        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        Router::redirect('/geofencing/edit/' . urlencode($id));
    }

    // Soft delete
    public function delete($id = null) {
        if (!$id) Router::redirect('/main?admin=ViewGeofencing');
        $ok = $this->model->softDelete($id);
        if ($ok) {
            $_SESSION['success'] = 'Zona eliminada.';
        } else {
            $_SESSION['error'] = 'Error eliminant la zona.';
        }
        Router::redirect('/main?admin=ViewGeofencing');
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