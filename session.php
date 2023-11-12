<?php
session_start();
include('includes' . DIRECTORY_SEPARATOR . 'database.php');

if (isset($_SESSION['users_email']) || isset($_SESSION['users_id'])) {
	$email = $_SESSION['users_email'];

	$sql = "SELECT id, email, status from users where email = :email";
	$params = [
		':email' => $email,
	];

	$stmt = $db->executePreparedStatement($sql, $params);
	if ($stmt) {
		$user = $db->fetchRow($stmt);
	} else {
		die("Error selecting data: " . $stmt->error);
	}
}