<?php
class BaseModel {
    protected $pdo;
    protected $table;

    public function __construct($tableName = null) {
        $host = getenv('POSTGRES_HOST') ?: 'postgres_db';
        $port = getenv('POSTGRES_PORT') ?: '5432';
        $db   = getenv('POSTGRES_DB') ?: 'blinkdb';
        $user = getenv('POSTGRES_USER') ?: 'admin';
        $pass = getenv('POSTGRES_PASSWORD') ?: 'qzn6FgX=S0C/3%(';

        $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die(json_encode([
                'success' => false,
                'message' => 'Error connecting to the database.',
                'error' => $e->getMessage()
            ]));
        }

        $this->table = $tableName;
    }

    // Obtener todos los registros activos
    public function all() {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE deleted = false");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Buscar por ID
    public function findById($id, $column = 'id') {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = ? AND deleted = false");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Crear registro
    public function create(array $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    // Actualizar registro
    public function update($id, array $data, $idColumn = 'id') {
        $setPart = implode(',', array_map(fn($key) => "$key = ?", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $setPart WHERE $idColumn = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([...array_values($data), $id]);
    }

    // Eliminación lógica
    public function softDelete($id, $column = 'id') {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET deleted = true WHERE {$column} = ?");
        return $stmt->execute([$id]);
    }
}
