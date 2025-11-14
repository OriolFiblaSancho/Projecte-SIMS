<?php

require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $db;
    private $table = 'users';

    /**
     * Allow injecting a DB connection for easier testing.
     * If no $db is provided, fall back to the singleton Database.
     *
     * @param mixed|null $db PDO-like connection object
     */
    public function __construct($db = null) {
        if ($db !== null) {
            $this->db = $db;
        } else {
            $this->db = Database::getInstance()->getConnection();
        }
    }

    public function getAllUsers() {
        $query = "SELECT * FROM {$this->table} WHERE deleted = false ORDER BY user_id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersCount() {
        $query = "SELECT COUNT(*) as cnt FROM {$this->table} WHERE deleted = false";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($row['cnt'] ?? 0);
    }

    public function getTotalBalance() {
        $query = "SELECT SUM(balance) as total FROM {$this->table} WHERE deleted = false";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($row['total'] ?? 0.0);
    }

    public function getVerifiedUsersCount() {
        $query = "SELECT COUNT(*) as cnt FROM {$this->table} WHERE deleted = false AND status = 'verified'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($row['cnt'] ?? 0);
    }

    public function getUsersByMonth($year = null) {
        if ($year === null) {
            $year = date('Y');
        }
        $query = "SELECT EXTRACT(MONTH FROM created_at) as month, COUNT(*) as cnt FROM {$this->table} WHERE deleted = false AND EXTRACT(YEAR FROM created_at) = :year AND created_at IS NOT NULL GROUP BY EXTRACT(MONTH FROM created_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data = array_fill(1, 12, 0);
        foreach ($results as $row) {
            $data[(int)$row['month']] = (int) $row['cnt'];
        }
        return $data;
    }

    public function getUsersPaginated($limit = 7, $offset = 0) {
        $query = "SELECT * FROM {$this->table} WHERE deleted = false ORDER BY user_id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersFiltered($limit = 7, $offset = 0, $filters = []) {
        $where = ["deleted = false"];
        $params = [];

        // Text search across multiple fields
        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $where[] = "(name ILIKE :search OR last_name ILIKE :search OR email ILIKE :search OR username ILIKE :search)";
            $params[':search'] = $search;
        }

        // Filter by user type
        if (!empty($filters['user_type'])) {
            $where[] = "user_type = :user_type";
            $params[':user_type'] = $filters['user_type'];
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $where[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        $whereClause = implode(' AND ', $where);
        $query = "SELECT * FROM {$this->table} WHERE {$whereClause} ORDER BY user_id ASC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsersCountFiltered($filters = []) {
        $where = ["deleted = false"];
        $params = [];

        // Text search across multiple fields
        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $where[] = "(name ILIKE :search OR last_name ILIKE :search OR email ILIKE :search OR username ILIKE :search)";
            $params[':search'] = $search;
        }

        // Filter by user type
        if (!empty($filters['user_type'])) {
            $where[] = "user_type = :user_type";
            $params[':user_type'] = $filters['user_type'];
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $where[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        $whereClause = implode(' AND ', $where);
        $query = "SELECT COUNT(*) as cnt FROM {$this->table} WHERE {$whereClause}";
        
        $stmt = $this->db->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (int) ($row['cnt'] ?? 0);
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

        // Require a password of at least 8 characters on create
        if ($password === null || $password === '') {
            return false;
        }
        if (strlen($password) < 8) {
            return false;
        }
        $password = password_hash($password, PASSWORD_DEFAULT);

        if ($email === null || $email === '') {
            return false;
        }
        $email = strtolower($email);
        $pattern = '/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/';
        if (!preg_match($pattern, $email)) {
            return false;
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

        if ($email === null || $email === '') {
            return false;
        }
        $email = strtolower($email);
        $pattern = '/^[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/';
        if (!preg_match($pattern, $email)) {
            return false;
        }

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        if ($passwordProvided) {
            if (strlen($data['password']) < 8) {
                return false;
            }
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
