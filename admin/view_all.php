matchmakers/dashboard.php
<?php
include(__DIR__ . '/../session.php');

if (!isset($_SESSION['users_id']) || !isset($_SESSION['users_email'])) {
    header("Location: " . dirname(__DIR__) . DIRECTORY_SEPARATOR . "index.php");
    exit();
}

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/navbar.php');

global $db;

// Get the logged-in matchmaker's user ID
$user_id = $_SESSION['users_id'];

$sql = "SELECT * FROM clients";

$params = [];

$stmt = $db->executePreparedStatement($sql, $params);

if ($stmt->rowCount() == 0) {
    $records = [];
} else {
    $records = $db->fetchAll($stmt);
}

// get the matchmaker's name for each client
foreach ($records as $key => $record) {
    $sql = "SELECT first_name, last_name FROM matchmakers WHERE id = :id";

    $params = [
        ':id' => $record['matchmaker_id']
    ];

    $stmt = $db->executePreparedStatement($sql, $params);

    if ($stmt->rowCount() == 0) {
        $records[$key]['matchmaker_name'] = "No matchmaker";
    } else {
        $matchmaker = $db->fetchRow($stmt);
        $records[$key]['matchmaker_name'] = $matchmaker['first_name'] . " " . $matchmaker['last_name'];
    }
}
?>

<div class="container-fluid">
    <div>
        <h1>All clients</h1>
        <p>Client count:
            <?php echo " " . count($records) ?>
        </p>
    </div>
    <table class="table table-hover table-striped-columns table-responsive align-middle fs-6 text-center">
        <thead>
            <th>
                Image
            </th>
            <th>
                Added by
            </th>
            <th>
                Full Name
            </th>
            <th>
                DOB
            </th>
            <th>
                Gender
            </th>
            <th>
                Education
            </th>
            <th>
                Occupation
            </th>
            <th>
                Income
            </th>
            <th>
                Address
            </th>
            <th>
                Description
            </th>
        </thead>
        <tbody>
            <?php
            foreach ($records as $row) { ?>
                <tr>
                    <td>
                        <img src="<?php echo "./../" . $row['photo_path'] ?>" alt="Image" style="max-width: 200px;">
                    </td>
                    <td>
                        <?php echo $row['matchmaker_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['first_name'] . " " . $row['last_name']; ?>
                    </td>
                    <td>
                        <?php echo $row['dob']; ?>
                    </td>
                    <td>
                        <?php echo $row['gender']; ?>
                    </td>
                    <td>
                        <?php echo $row['education']; ?>
                    </td>
                    <td>
                        <?php echo $row['occupation']; ?>
                    </td>
                    <td>
                        <?php echo $row['contact']; ?>
                    </td>
                    <td>
                        <?php echo $row['location']; ?>
                    </td>
                    <td>
                        <?php echo $row['description']; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

