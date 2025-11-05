<?php
require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../config/router.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getAll() {
        $users = $this->userModel->getAllUsers();
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Users/UsersTable.php';
    }

    /**
     * Mostra el detall d'un usuari concret
     */
    public function show($id = null) {
        if ($id === null) {
            Router::redirect('/main?admin=ViewUsers');
        }
        $user = $this->userModel->getById((int)$id);
        if (!$user) {
            $_SESSION['error'] = 'User not found';
            Router::redirect('/main?admin=ViewUsers');
        }
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Users/UserSingleView.php';
    }

    public function form($id = null) {
        $user = null;
        
        if ($id) {
            $user = $this->userModel->getById($id);
        }
        require_once __DIR__ . '/../views/main/components/AdminMenuComponents/Users/UsersForm.php';
    }

    public function create() {
        // Igual que a VehicleController::create(): si no és POST, sortim
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $result = $this->userModel->create($_POST);

        if ($result) {
            $_SESSION['success'] = 'User created successfully!';
            Router::redirect('/main?admin=ViewUsers');
        } else {
            $_SESSION['error'] = 'Error creating user';
            Router::redirect('/main?admin=FormUsers');
        }
    }

    public function update($id = null) {
        if ($id === null) {
            $id = $_POST['id'] ?? null;
        }

        // Seguint l'estil de VehicleController: si no és POST, sortim
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$id) {
            return;
        }

        $ok = $this->userModel->update((int)$id, $_POST);
        if ($ok) {
            $_SESSION['success'] = 'User updated successfully!';
        } else {
            $_SESSION['error'] = 'Error updating user';
        }
        Router::redirect('/main?admin=ViewUsers');
    }

    public function delete($id = null) {
        if ($id === null) {
            $id = $_GET['id'] ?? null;
        }
        if (!$id) {
            Router::redirect('/main?admin=ViewUsers');
        }

        $ok = $this->userModel->delete((int)$id);
        if ($ok) {
            $_SESSION['success'] = 'User deleted successfully!';
        } else {
            $_SESSION['error'] = 'Error deleting user';
        }
        Router::redirect('/main?admin=ViewUsers');
    }
}

?>
