<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/router.php';

class userSettingsController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Router::redirect('/main');
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            $_SESSION['error'] = 'Sessió no iniciada.';
            Router::redirect('/main?settings=1');
        }

        $allowed = ['username','name','last_name','phone','driver_license'];
        $setParts = [];
        $params = [':id' => (int)$userId];
        foreach ($allowed as $key) {
            if (isset($_POST[$key]) && $_POST[$key] !== '') {
                $setParts[] = "$key = :$key";
                $params[":".$key] = trim($_POST[$key]);
            }
        }

        if (!$setParts) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'No hi ha canvis a desar.']);
                return;
            }
            $_SESSION['success'] = 'No hi ha canvis a desar.';
            Router::redirect('/main?settings=1');
        }

        $sql = 'UPDATE users SET ' . implode(', ', $setParts) . ' WHERE user_id = :id';
        try {
            $stmt = $this->db->prepare($sql);
            $ok = $stmt->execute($params);
            if ($ok) {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    $fetch = $this->db->prepare("SELECT username, name, last_name, email, phone, driver_license FROM users WHERE user_id = :id AND deleted = false");
                    $fetch->execute([':id' => (int)$userId]);
                    $userRow = $fetch->fetch(PDO::FETCH_ASSOC) ?: [];
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Ajustos desats correctament.', 'user' => $userRow]);
                    return;
                }
                $_SESSION['success'] = 'Ajustos desats correctament.';
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'No s\'ha pogut desar.']);
                    return;
                }
                $_SESSION['error'] = 'No s\'ha pogut desar.';
            }
        } catch (Exception $e) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Error al desar.']);
                return;
            }
            $_SESSION['error'] = 'Error al desar.';
            Router::redirect('/main?settings=1');
        }
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            Router::redirect('/main?settings=1');
        }
    }
}

?>
