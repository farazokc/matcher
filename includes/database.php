<?php

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $servername = '127.0.0.1';
        $username = 'root';
        $password = '';
        $dbname = 'matrimonial';

        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // die("Connection failed: " . $e->getMessage());
            die("Connection failed: " . $e);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function executeQuery($sql) {
        return $this->conn->exec($sql);
    }

    public function fetchRow($result) {
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll($result) {
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function executePreparedStatement($sql, $params) {
        $stmt = $this->conn->prepare($sql);

        foreach($params as $param => &$value) {
            $stmt->bindParam($param, $value);
        }

        $stmt->execute($params);
        return $stmt;
    }

    public function getLastInsertID() {
        return $this->conn->lastInsertId();
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

$db = Database::getInstance();