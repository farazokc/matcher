<?php
session_start();
include('includes/database.php');
$email = $_SESSION['users_email'];

$sql = "SELECT * from users where email = :email";
$params = [
	':email' => $email,
];

$stmt = $db->executePreparedStatement($sql, $params);
if ($stmt) {
	$user = $db->fetchRow($stmt);
} else {
	die("Error selecting data: " . $stmt->error);
}