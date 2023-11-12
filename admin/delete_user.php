<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $db;

    // ID of person whose account is to be deleted
    $users_id = $_POST['id'];

    // select the clients of the current user from the clients table
    $sql_clients = "SELECT clients.*
                    FROM users 
                    INNER JOIN matchmakers ON users.id = matchmakers.user_id
                    INNER JOIN clients ON matchmakers.id = clients.matchmaker_id
                    WHERE users.id = :id;";

    $params_clients = [
        ':id' => $users_id
    ];

    $stmt_clients = $db->executePreparedStatement($sql_clients, $params_clients);
    $clients = $db->fetchAll($stmt_clients);

    if ($clients) {
        foreach ($clients as $client) {
            $img_path = __DIR__ . "/../" . $client['photo_path'];
            $img_path = str_replace('\\', '/', $img_path);

            if (file_exists($img_path)) {
                $sql = "DELETE FROM clients WHERE id = :id";
                $params = [':id' => $client['id']];

                // echo "Will execute record delete stmt";
                $stmt = $db->executePreparedStatement($sql, $params);

                if ($stmt) {
                    unlink($img_path);
                    // echo "success";
                } else {
                    echo "Error deleting clients record";
                    exit();
                }
            }
        }
    }

    // select the matchmakers of the current user from the matchmakers table
    $sql_matchmakers = "SELECT matchmakers.*
                        FROM users 
                        INNER JOIN matchmakers ON users.id = matchmakers.user_id
                        WHERE users.id = :id;";

    $params_matchmakers = [
        ':id' => $users_id
    ];

    $stmt_matchmakers = $db->executePreparedStatement($sql_matchmakers, $params_matchmakers);
    $matchmakers = $db->fetchAll($stmt_matchmakers);

    if ($matchmakers) {
        foreach ($matchmakers as $matchmaker) {
            $sql = "DELETE FROM matchmakers WHERE id = :id";
            $params = [':id' => $matchmaker['id']];

            $stmt = $db->executePreparedStatement($sql, $params);

            if (!$stmt) {
                echo "Error deleting matchmaker record";
                exit();
            }
        }
    }

    // select the current from users table
    $sql_users = "SELECT users.*
                  FROM users 
                  WHERE users.id = :id;";

    $params_users = [
        ':id' => $users_id
    ];

    $stmt_users = $db->executePreparedStatement($sql_users, $params_users);
    $users = $db->fetchAll($stmt_users);
    if ($users) {
        foreach ($users as $user) {
            $sql = "DELETE FROM users WHERE id = :id";
            $params = [':id' => $user['id']];

            $stmt = $db->executePreparedStatement($sql, $params);

            if (!$stmt) {
                echo "Error deleting user record";
                exit();
            }
        }
    }

    echo "success";
}

?>