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

// class Database {
//     private static $instance = null;
//     private $conn;

//     private function __construct() {
//         $servername = 'localhost';
//         $username = 'root';
//         $password = '';
//         $dbname = 'matrimonial';

//         try {
//             $this->conn = new mysqli($servername, $username, $password, $dbname);
//             if ($this->conn->connect_error) {
//                 throw new Exception("Connection failed: " . $this->conn->connect_error);
//             }
//         } catch (Exception $e) {
//             die($e->getMessage());
//         }
//     }

//     public static function getInstance() {
//         if (self::$instance == null) {
//             self::$instance = new Database();
//         }
//         return self::$instance;
//     }

//     public function executeQuery($sql) {
//         try {
//             $result = $this->conn->query($sql);
//             if ($result === false) {
//                 throw new Exception("Error executing query: " . $this->conn->error);
//             }
//             return $result;
//         } catch (Exception $e) {
//             die($e->getMessage());
//         }
//     }

//     public function executePreparedStatement($sql, $types, $params) {
//         try {
//             $stmt = $this->conn->prepare($sql);
//             if ($stmt === false) {
//                 throw new Exception("Error preparing statement: " . $this->conn->error);
//             }

//             $stmt->bind_param($types, ...$params);
//             $stmt->execute();

//             if ($stmt->error) {
//                 throw new Exception("Error executing prepared statement: " . $stmt->error);
//             }

//             return $stmt;
//         } catch (Exception $e) {
//             die($e->getMessage());
//         }
//     }

//     public function fetchRow($result) {
//         return $result->fetch_assoc();
//     }

//     public function fetchAll($result) {
//         $rows = array();
//         while ($row = $result->fetch_assoc()) {
//             $rows[] = $row;
//         }
//         return $rows;
//     }

//     public function getLastInsertID() {
//         return $this->conn->insert_id;
//     }

//     public function closeConnection() {
//         $this->conn->close();
//     }
// }

// $db = Database::getInstance();
