<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $db;

    $client_id = $_POST['id'];
    // echo "Client ID: " . $client_id . "<br>";

    $sql = "SELECT photo_path FROM clients WHERE id = :id";

    $params = [':id' => $client_id];
    $stmt = $db->executePreparedStatement($sql, $params);
    // echo "Image delete stmt executed" . "<br>";

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // echo "Image record found" . "<br>";

        // delete the image from the images folder
        if ($row['photo_path']) {
            $img_path = __DIR__ . "/../" . $row['photo_path'];
            $img_path = str_replace('\\', '/', $img_path);

            // echo "Image path: " . $img_path . "<br>";

            if (file_exists($img_path)) {
                // echo "Image exists at " . $img_path . "<br>";

                unset($sql, $params, $stmt);

                // Delete the client with the specified ID
                $sql = "DELETE FROM clients WHERE id = :id";
                $params = [':id' => $client_id];

                // echo "Will execute record delete stmt";
                $stmt = $db->executePreparedStatement($sql, $params);

                if ($stmt) {
                    unlink($img_path);
                    echo "success";
                } else {
                    echo "recordDelError";
                }
            }
        }
    } else {
        echo "imgDelError";
    }
}

?>