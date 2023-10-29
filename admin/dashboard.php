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
// Show table listing all users of system

$sql = "SELECT * FROM users where `status` != 2 ORDER BY `status` ASC";
$params = [
    // ':status' => 2
];

$stmt = $db->executePreparedStatement($sql, $params);
$result = $db->fetchAll($stmt);

// // $sql = "SELECT * FROM clients";
// // $params = [];

// // $stmt = $db->executePreparedStatement($sql, $params);

// // if ($stmt->rowCount() == 0) {
// //     $records = [];
// // } else {
// //     $records = $db->fetchAll($stmt);
// // }

// // get the matchmaker's name for each client
// foreach ($records as $key => $record) {
//     $sql = "SELECT first_name, last_name FROM matchmakers WHERE id = :id";

//     $params = [
//         ':id' => $record['matchmaker_id']
//     ];

//     $stmt = $db->executePreparedStatement($sql, $params);

//     if ($stmt->rowCount() == 0) {
//         $records[$key]['matchmaker_name'] = "No matchmaker";
//     } else {
//         $matchmaker = $db->fetchRow($stmt);
//         $records[$key]['matchmaker_name'] = $matchmaker['first_name'] . " " . $matchmaker['last_name'];
//     }
// }

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

<div class="container">
    <?php if ($result == []) {
        echo "<h3>No users are present</h3>";
    } else {
        ?>
        <div>
            <h4>Total number of matchmakers:
                <?php echo " " . count($result) ?>
            </h4>
        </div>
        <h2>Matchmaker Details</h2>
        <table class="table table-hover table-striped-columns table-responsive align-middle fs-6 text-center">
            <!-- <thead>
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
            </thead> -->
            <thead>
                <!-- id, email, status -->
                <th>
                    ID
                </th>
                <th>
                    Email
                </th>
                <th>
                    Status
                </th>
                <th>
                    Change Authorization
                </th>
                <th>
                    Operations
                </th>
            </thead>
            <tbody>
                <?php
                foreach ($result as $row) { ?>
                    <tr>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>
                        <td>
                            <?php echo $row['email'] ?>
                        </td>
                        <?php if ($row['status']) { ?>
                            <td>
                                Active
                            </td>
                            <td>
                                <div>
                                    <a class="text-light" style="text-decoration: none;"
                                        onclick='sendRequest("deauthorize", <?php echo $row["id"]; ?>)'>
                                        <button class="btn btn-danger">
                                            Deauthorize
                                        </button>
                                    </a>
                                </div>
                            </td>
                        <?php } else { ?>
                            <td>
                                Inactive
                            </td>
                            <td>
                                <div>
                                    <a class="text-light" style="text-decoration: none;"
                                        onclick='sendRequest("authorize", <?php echo $row["id"]; ?>)'>
                                        <button class="btn btn-success">
                                            Authorize
                                        </button>
                                    </a>
                                </div>
                            </td>
                        <?php } ?>
                        <td>
                            <div class="d-flex justify-content-around">
                                <div>
                                    <a class="edit-user text-light" style="text-decoration: none;"
                                        href="<?php echo "./edit_user.php?id=" . $row['id'] ?>">
                                        <button class="btn btn-info">
                                            Edit
                                        </button>
                                    </a>
                                </div>
                                <div>
                                    <a class="delete-user text-light" style="text-decoration: none;"
                                        href="<?php echo "./delete_user.php?id=" . $row['id'] ?>">
                                        <button class="btn btn-danger">
                                            Delete
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<script>
    const sendRequest = (operation, clientId) => {
        let confirmOperation = confirm("Are you sure you want to " + operation + " this user?");
        if (confirmOperation) {
            $.ajax({
                url: "authorize_user.php",
                type: "POST",
                data: {
                    id: clientId,
                    operation: operation
                },
                success: function (data) {
                    if (data == "success") {
                        alert('User ' + operation + 'd successfully');
                        console.log(data);
                        window.location.reload();
                    } else {
                        alert('User not ' + operation + 'd');
                    }
                },
                error: function (e) {
                    alert(e);
                }
            });
        }
    }
</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>