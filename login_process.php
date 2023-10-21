<?php
session_start();
include('includes/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['type'];
    $message = null;

    $sql = "SELECT * FROM users WHERE email = :email";
    $params = [
        ':email' => $email
    ];

    $stmt = $db->executePreparedStatement($sql, $params);
    $row = $db->fetchRow($stmt);

    if ($row && $password == $row['password']) {

        //redirect to matchmaker dashboard
        if($type == 'user' && $row['is_admin'] == 0){
            $message = "user";
            // if user is a matchmaker, get matchmaker's info
            $mm_sql = "SELECT * FROM matchmakers WHERE user_id = :user_id";
            $mm_params = [
                ':user_id' => $row['id']
            ];

            $mm_stmt = $db->executePreparedStatement($mm_sql, $mm_params);
            $mm_row = $db->fetchRow($mm_stmt);

            $_SESSION['matchmakers_id'] = $mm_row['id'];


        //redirect to pending admin dashboard
        } else if ($type == 'admin' && $row['is_admin'] == 1) {
            $message = "pending";


        //redirect to admin dashboard
        } else if ($type == 'admin' && $row['is_admin'] == 2) {
            $message = "admin";
        }

        //users_id mein id from 
        $_SESSION['users_id'] = $row['id'];
        $_SESSION['users_type'] = $type;
        $_SESSION['users_is_admin'] = $row['is_admin'];
        $_SESSION['users_email'] = $row['email'];

        $response = array(
            'success' => true,
            'message' => $message
        );

        echo json_encode($response);
    } else {
        $response = array(
            'success' => false,
            'message' => "pwd"
        );

        echo json_encode($response);
    }
}
