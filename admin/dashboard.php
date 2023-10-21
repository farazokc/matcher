<!-- admin/dashboard.php -->

<?php
include(__DIR__ . '/../session.php');

if (!isset($_SESSION['users_email'])) {
    global $home;
    header("Location: " . dirname(__DIR__) . DIRECTORY_SEPARATOR . "index.php");
    exit();
}

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/navbar.php');

global $db;

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
<style>
    button a {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Inherit color from parent element (button) */
    }
</style>

<div class="container-fluid">
    <!-- <h1 class="text-center">Welcome, <?php ?></h1> -->
    <h1 class="text-center">Welcome, Admin</h1>
</div>

<div class="container-fluid">
    <?php if ($records == []) {
        echo "<h3>No clients have been added</h3>";
    } else {
        ?>
        <div>
            <h4>Number of total clients:
                <?php echo " " . count($records) ?>
            </h4>
        </div>
        <h2>Details</h2>
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
                            <img src="<?php echo "./../" . $row['photo_path'] ?>" alt="Image" style="max-width: 100px;">
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
    <?php } ?>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>