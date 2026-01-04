<?php 

class Database {
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct() {
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=buymatch;charset=utf8",
            "root",
            "mouhsinerouaki",
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}
