<?php

require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $db;
    private $table = 'users';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM {$this->table} WHERE deleted = false ORDER BY user_id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :id AND deleted = false";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (username, name, last_name, email, password, phone, user_type, balance, driver_license, status, created_at, deleted)
                  VALUES (:username, :name, :last_name, :email, :password, :phone, :user_type, :balance, :driver_license, :status, NOW(), false)";
        $stmt = $this->db->prepare($query);

        $username = isset($data['username']) ? trim($data['username']) : null;
        $name = isset($data['name']) ? trim($data['name']) : null;
        $last_name = isset($data['last_name']) ? trim($data['last_name']) : null;
        $email = isset($data['email']) ? trim($data['email']) : null;
        $password = isset($data['password']) ? $data['password'] : null;
        $phone = isset($data['phone']) ? trim($data['phone']) : null;
        $user_type = isset($data['user_type']) ? trim($data['user_type']) : 'customer';
        $balance = isset($data['balance']) && $data['balance'] !== '' ? floatval($data['balance']) : 0.0;
        $driver_license = isset($data['driver_license']) ? trim($data['driver_license']) : null;
        $status = isset($data['status']) ? trim($data['status']) : 'non-verified';

        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $password = null; 
        }

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':balance', $balance);
        $stmt->bindParam(':driver_license', $driver_license);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $data) {
        $passwordProvided = isset($data['password']) && $data['password'] !== '';

        if ($passwordProvided) {
            $query = "UPDATE {$this->table} SET username=:username, name=:name, last_name=:last_name, email=:email, password=:password, phone=:phone, user_type=:user_type, balance=:balance, driver_license=:driver_license, status=:status WHERE user_id = :id";
        } else {
            $query = "UPDATE {$this->table} SET username=:username, name=:name, last_name=:last_name, email=:email, phone=:phone, user_type=:user_type, balance=:balance, driver_license=:driver_license, status=:status WHERE user_id = :id";
        }

        $stmt = $this->db->prepare($query);

        $username = isset($data['username']) ? trim($data['username']) : null;
        $name = isset($data['name']) ? trim($data['name']) : null;
        $last_name = isset($data['last_name']) ? trim($data['last_name']) : null;
        $email = isset($data['email']) ? trim($data['email']) : null;
        $phone = isset($data['phone']) ? trim($data['phone']) : null;
        $user_type = isset($data['user_type']) ? trim($data['user_type']) : 'customer';
        $balance = isset($data['balance']) && $data['balance'] !== '' ? floatval($data['balance']) : 0.0;
        $driver_license = isset($data['driver_license']) ? trim($data['driver_license']) : null;
        $status = isset($data['status']) ? trim($data['status']) : 'non-verified';

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        if ($passwordProvided) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $password);
        }
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':balance', $balance);
        $stmt->bindParam(':driver_license', $driver_license);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "UPDATE {$this->table} SET deleted = true WHERE user_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
