<?php
    $adminSection = $_GET['admin'] ?? null;
    if ($adminSection !== null) {
        if (strpos($adminSection, 'Vehicle') !== false) {
            require_once __DIR__ . '/./vehicleController.php';
            require_once __DIR__ . '/./vehicleTypeController.php';
            $vc = new VehicleController();
            $vtc = new VehicleTypeController();

            if ($adminSection === 'ViewVehicles') {
                $vc->getAll();
            } else if ($adminSection === 'FormVehicles') {
                $vtc->getAll();
            } else if ($adminSection === 'ViewVehicle') {
                $id = $_GET['id'] ?? null;
                $vc->view($id);
            }
            
        } else if (strpos($adminSection, 'User') !== false) {
            require_once __DIR__ . '/./userController.php';
            $uc = new UserController();

            if ($adminSection === 'ViewUsers') {
                $uc->getAll();
            } else if ($adminSection === 'ViewUser') {
                $uc->show($_GET['id'] ?? null);
            } else if ($adminSection === 'FormUsers') {
                $uc->form($_GET['id'] ?? null);
            }
        } else if (strpos($adminSection, 'Geofencing') !== false) {
            require_once __DIR__ . '/./geofencingController.php';
            $gfc = new GeofencingController();

            if ($adminSection === 'ViewGeofencing') {
                $gfc->getAll();
            } else if ($adminSection === 'FormGeofencing') {
                $id = $_GET['edit'] ?? null;
                if ($id) {
                    $gfc->edit($id);
                } else {
                    $gfc->create();
                }
            } else if ($adminSection === 'ViewGeofencingSingle') {
                $id = $_GET['id'] ?? null;
                $gfc->view($id);
            }
        } else if ($adminSection === 'Dashboard') {
            require_once __DIR__ . '/./dashboardController.php';
            $dc = new DashboardController();
            $dc->index();
        }
    }
    ?>