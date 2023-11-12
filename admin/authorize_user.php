<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['operation']) && isset($_POST['id'])) {
    global $db;

    $id = $_POST['id'];
    $operation = $_POST['operation'];

    // deauthorize
    if ($operation == 'authorize') {
        $sql = "UPDATE users SET status = :status WHERE id = :id";
        $params = [
            ':status' => 1,
            ':id' => $id
        ];

        $stmt = $db->executePreparedStatement($sql, $params);
        if ($stmt->rowCount() > 0) {
            echo "success";
        } else {
            echo "error";
        }
    } else if ($operation == 'deauthorize') {
        $sql = "UPDATE users SET status = :status WHERE id = :id";
        $params = [
            ':status' => 0,
            ':id' => $id
        ];

        $stmt = $db->executePreparedStatement($sql, $params);
        if ($stmt->rowCount() > 0) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
?>