<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = getenv('POSTGRES_HOST');
        $db   = getenv('POSTGRES_DB');
        $user = getenv('POSTGRES_USER');
        $pass = getenv('POSTGRES_PASSWORD');
        $charset = 'utf8';

        $dsn = "pgsql:host=$host;dbname=$db;options='--client_encoding=$charset'";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
    
    // Evita clonar la instància
    private function __clone() {}
    
    // Evita deserialitzar la instància
    public function __wakeup() {
        throw new Exception("No es pot deserialitzar un singleton");
    }
}
?>
