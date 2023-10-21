<?php
session_start();
include('includes/database.php');

// $home = __DIR__ . DIRECTORY_SEPARATOR . "index.php";

// echo "SESSION Dump in session.php: <br>";
// echo "<pre>";
// echo var_dump($_SESSION);
// echo "</pre>";

if (isset($_SESSION['users_email']) || isset($_SESSION['users_id'])) {
	$email = $_SESSION['users_email'];

	$sql = "SELECT id, email, is_admin from users where email = :email";
	$params = [
		':email' => $email,
	];

	$stmt = $db->executePreparedStatement($sql, $params);
	if ($stmt) {
		$user = $db->fetchRow($stmt);
	} else {
		// echo "dying";
		die("Error selecting data: " . $stmt->error);
	}
}
// }