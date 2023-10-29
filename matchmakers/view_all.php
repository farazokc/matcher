<!-- matchmakers/dashboard.php -->
<?php
include(__DIR__ . '\\..\\session.php');
// include(dirname(__DIR__) . '\\session.php');

if (!isset($_SESSION['users_id']) || !isset($_SESSION['users_email'])) {
    // Redirect to login page if not logged in as a matchmaker
    header("Location: " . dirname(__DIR__) . DIRECTORY_SEPARATOR . "index.php");
    exit();
}

include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/navbar.php');
include(__DIR__ . '/dashboard.php');

global $db;

$user_id = $_SESSION['users_id'];

// Get the matchmaker's ID from clients table
$sql = "SELECT clients.matchmaker_id 
        FROM clients 
        JOIN matchmakers ON clients.matchmaker_id = matchmakers.id 
        JOIN users ON matchmakers.user_id = users.id
        WHERE users.id = :id;";

$params = [
    ':id' => $user_id
];

$stmt = $db->executePreparedStatement($sql, $params);

if ($stmt->rowCount() == 0) {
    $matchmaker_id = 0;
} else {
    $matchmaker_id = $db->fetchRow($stmt)['matchmaker_id'];
}

// get the matchmaker's clients
$sql = "SELECT * FROM clients WHERE matchmaker_id = :id";

$params = [
    ':id' => $matchmaker_id
];

$stmt = $db->executePreparedStatement($sql, $params);

if ($stmt->rowCount() == 0) {
    $clients = [];
} else {
    $clients = $db->fetchAll($stmt);
}

global $user;
$name_sql = "SELECT first_name, last_name FROM matchmakers WHERE user_id = :id";
$params = [
    ':id' => $user['id']
];
$stmt = $db->executePreparedStatement($name_sql, $params);
$name = $db->fetchRow($stmt);
$user_name = $name['first_name'] . " " . $name['last_name'];
?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Welcome,
                <?php echo $user_name ?>
            </h1>
        </div>
        <?php if ($clients == []) {
            echo "<h3>No clients have been added</h3>";
        } else {
            ?>
            <div>
                <h4>Number of total clients:
                    <?php echo " " . count($clients) ?>
                </h4>
            </div>
            <table class="table table-hover table-striped-columns table-responsive align-middle fs-5 text-center">
                <thead>
                    <th>
                        Image
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Age
                    </th>
                    <th>
                        Gender
                    </th>
                    <th>
                        Education
                    </th>
                    <th>
                        Income
                    </th>
                    <th>
                        CNIC #
                    </th>
                    <th>
                        Actions
                    </th>
                </thead>
                <tbody>
                    <?php
                    foreach ($clients as $row) { ?>
                        <tr>
                            <td>
                                <img src="<?php echo "./../" . $row['photo_path'] ?>" alt="Image" style="max-width: 100px;">
                            </td>
                            <td>
                                <?php echo $row['name'] ?>
                            </td>
                            <td>
                                <?php echo $row['age']; ?>
                            </td>
                            <td>
                                <?php echo $row['gender']; ?>
                            </td>
                            <td>
                                <?php echo $row['education']; ?>
                            </td>
                            <td>
                                <?php echo $row['income']; ?>
                            </td>
                            <td>
                                <?php echo $row['cnic']; ?>
                            </td>
                            <td>
                                <div>
                                    <a class="view-client text-light" style="text-decoration: none;"
                                        href="<?php echo "./view_client.php?id=" . $row['id'] ?>">
                                        <button class="btn btn-primary">
                                            View
                                        </button>
                                    </a>
                                </div>
                                <div>
                                    <a class="edit-client text-light" style="text-decoration: none;"
                                        href="<?php echo "./edit_client.php?id=" . $row['id'] ?>">
                                        <button class="btn btn-warning">
                                            Edit
                                        </button>
                                    </a>
                                </div>
                                <div>
                                    <a class="delete-client text-light" style="text-decoration: none;"
                                        onclick='sendRequest("delete", <?php echo $row["id"]; ?>)'>
                                        <button class="btn btn-danger">
                                            Delete
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <?php include(__DIR__ . '/../includes/footer.php'); ?>

    <script>
        const sendRequest = (operation, clientId) => {
            if (operation == "delete") {
                deleteClient(clientId);
            } else if (operation == "view") {
                viewClient(clientId);
            } else if (operation == "edit") {
                editClient(clientId);
            }
        }

        const deleteClient = (clientId) => {
            let confirmDelete = confirm("Are you sure you want to delete this client?");
            if (confirmDelete) {
                console.log("Deleting client with ID: " + clientId);
                // window.location.href = "./delete_client.php?id=" + clientId;

                $.ajax({
                    url: "delete_client.php",
                    type: "POST",
                    data: { id: clientId },
                    success: function (data) {
                        if (data == "success") {
                            alert('Record deleted successfully');
                            window.location.reload();
                        } else if (data == "imgDelError") {
                            alert("Error deleting record image");
                        } else if (data == "recordDelError") {
                            alert('Error deleting record');
                        }
                    },
                    error: function (e) {
                        alert(e);
                    }
                });
            }
        }
    </script>