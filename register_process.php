<?php
include(__DIR__ . '\\session.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // removed admin option
    // $type = $_POST['type'];
    // $type_val = 0;

    // if ($type == 'user') {
    //     $type_val = 0;
    // } else if ($type == 'admin') {
    //     $type_val = 1;
    // }


    // only user registration available
    $type = 'user';
    $type_val = 0;

    $sql = "INSERT INTO users (email, password, is_admin) VALUES (:email, :password, :is_admin)";

    $params = [
        ':email' => $email,
        ':password' => $password,
        ':is_admin' => $type_val,
    ];

    try {
        $db->executePreparedStatement($sql, $params);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    // REMOVED TYPE CHECK FOR NOW

    // if ($type == 'user') {
    $sql = 'SELECT MAX(id) as id from users';
    $params = [];

    $stmt = $db->executePreparedStatement($sql, $params);
    $row = $db->fetchRow($stmt);

    $user_id = $row['id'];

    //insert user's info into matchmakers table
    $sql = "INSERT INTO matchmakers (user_id, first_name, last_name, email, phone) 
            VALUES (:user_id, :first_name, :last_name, :email, :phone)";

    $params = [
        ':user_id' => $user_id,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':phone' => $phone,
    ];

    try {
        $stmt = $db->executePreparedStatement($sql, $params);
        // $row = $db->fetchRow($stmt);

        $current_id = $db->getLastInsertID();
        // echo "current id: " . $current_id . "<br>";
        // exit();
        // unset($sql, $params, $stmt, $row);

        $sql = "SELECT * FROM matchmakers WHERE id = :id";
        $params = [
            ':id' => $current_id
        ];
        $stmt = $db->executePreparedStatement($sql, $params);
        $row = $db->fetchRow($stmt);

        // chahiye kia:
        //  from users table: id, email
        //  from matchmakers table:  

        // users_id mein user_id from users table
        // USERS ID SET HO GYI HAI
        $_SESSION['users_id'] = $row['user_id'];
        $_SESSION['users_type'] = $type;
        $_SESSION['users_is_admin'] = $type_val;
        $_SESSION['users_email'] = $row['email'];

        // echo "SESSION Dump in register_process: <br>";
        // echo "<pre>";
        // echo var_dump($_SESSION);
        // echo "</pre>";
        // exit();

        // echo "User created successfully <br>";
        // if (file_exists('./matchmakers/view_all.php')) {
        //     echo "Exists";
        // } else {
        //     echo "Doesn't exist";
        // }

        header("Location: ./matchmakers/view_all.php");
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    // } 
    // else if ($type == 'admin') {
    //     header("Location: admin/pending.php");
    //     exit();
    // }
} else {
    header("Location: register.php"); // Redirect if accessed directly
}

exit();