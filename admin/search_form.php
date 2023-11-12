<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $db;
    
    $params = [];
    $whereClauses = [];

    $searchColumns = [
        'gender',
        'age',
        'marital_status',
        'education',
        'city',
        'country'
    ];

    foreach ($searchColumns as $column) {
        if (isset($_POST[$column]) && $_POST[$column] !== '') {
            $whereClauses[] = "$column = :$column";
            $params[":$column"] = $_POST[$column];
        }
    }

    // echo "WHERE CLAUSE: ";
    // print_r($whereClauses);

    $whereClause = implode(' AND ', $whereClauses);

    $sql = "SELECT id, name, age, gender, marital_status, education, city, country FROM clients";

    if (!empty($whereClause)) {
        $sql .= " WHERE $whereClause";
    }

    // get all the clients
    $stmt = $db->executePreparedStatement($sql, $params);
    if (!$stmt) {
        die('Error executing query');
    }

    $result = $db->fetchAll($stmt);

    // return the results as JSON
    if (count($result) > 0) {
        echo json_encode($result);
    } else {
        echo json_encode([]);
    }
}
?>
