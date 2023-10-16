<?php
session_start();
include('includes/database.php');

$home = __DIR__ . DIRECTORY_SEPARATOR . "index.php";

if (isset($_SESSION['users_email'])) {
	$email = $_SESSION['users_email'];

	$sql = "SELECT * from users where email = :email";
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