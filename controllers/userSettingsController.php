<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/router.php';
require_once __DIR__ . '/../helpers/i18n.php';
set_locale();

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
                    echo json_encode(['success' => true, 'message' => t('no_changes_to_save')]);
                    return;
                }
            $_SESSION['success'] = t('no_changes_to_save');
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
                    echo json_encode(['success' => true, 'message' => t('settings_saved'), 'user' => $userRow]);
                    return;
                }
                $_SESSION['success'] = t('settings_saved');
            } else {
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => t('save_failed')]);
                    return;
                }
                $_SESSION['error'] = t('save_failed');
            }
        } catch (Exception $e) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => t('error_saving')]);
                return;
            }
            $_SESSION['error'] = t('error_saving');
            Router::redirect('/main?settings=1');
        }
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            Router::redirect('/main?settings=1');
        }
    }
}

?>
