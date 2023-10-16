<!-- matchmakers/dashboard.php -->
<?php 
session_start();
include(__DIR__.'/../includes/database.php');
include(__DIR__.'/../includes/header.php'); 
include(__DIR__.'/navbar.php');


// Check if the matchmaker is logged in
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'matchmaker') {
    // Redirect to login page if not logged in as a matchmaker
    header("Location: login.php");
    exit();
}

// Get the logged-in matchmaker's ID
$matchmaker_id = $_SESSION['user_id'];

// Query the database to get clients associated with the matchmaker
$db = Database::getInstance();
$sql = "SELECT * FROM Clients WHERE matchmaker_id = ?";
$params = array($matchmaker_id);
$stmt = $db->executePreparedStatement($sql, $params);

// Fetch all rows associated with the matchmaker
$clients = $db->fetchAll($stmt);

// Now $clients contains all the clients associated with the matchmaker

// Display the clients (you can modify this part according to your requirements)
foreach ($clients as $client) {
    echo "Client ID: " . $client['client_id'] . "<br>";
    echo "Name: " . $client['first_name'] . " " . $client['last_name'] . "<br>";
    // Add more fields as needed
    echo "<hr>";
}

?>

<div class="dashboard-container">
    <h1>All clients</h1>
</div>

<?php include(__DIR__.'/../includes/footer.php'); ?>
