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

<style>
    /* Custom CSS */
    .form-control:focus {
        border-color: #ff0000;
        /* Change this color to your desired outline color */
        box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25);
        /* Optional: Change this for a focus shadow */
    }

    /* Optional: Change the color on hover */
    .form-control:hover {
        border-color: #ff9999;
        /* Change this color to your desired hover outline color */
    }

    /* div {
        outline: 1px solid red;
    } */
</style>


<div class="container">
    <h1 class="text-center">Welcome,
        <?php echo ucfirst($user_name); ?>
    </h1>
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-sm-12 col-md-6 col-lg-3 text-center me-2">
            Filter clients by name:
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3">
            <input type="text" class="form-control" id="searchName" placeholder="Enter name">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-3 fs-5 text-center mb-3">
            <?php if ($clients == []) { ?>
                No clients have been added
            </div>
        <?php } else { ?>
            Number of total clients:
            <?php echo " " . count($clients) ?>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-hover table-striped-columns align-middle fs-5 text-center">
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
                                <!-- first letter capital -->
                                <?php echo ucfirst($row['name']) ?>
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
                                <?php echo round($row['income']); ?>
                            </td>
                            <td>
                                <?php echo $row['cnic']; ?>
                            </td>
                            <td>
                                <div class="d-flex justify-content-around align-items-center">
                                    <div class="mb-1">
                                        <a class="view-client text-light" style="text-decoration: none;"
                                            href='<?php echo "./view_client.php?id=" . $row['id'] . "&mode=view" ?>'>
                                            <button class="btn btn-primary">
                                                View
                                            </button>
                                        </a>
                                    </div>
                                    <div class="mb-1">
                                        <a class="edit-client text-light" style="text-decoration: none;"
                                            href="<?php echo "./edit_client.php?id=" . $row['id'] ?>">
                                            <button class="btn btn-warning">
                                                Edit
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around align-items-center">
                                    <div class="mb-1">
                                        <a class="delete-client text-light" style="text-decoration: none;"
                                            onclick='sendRequest("delete", <?php echo $row["id"]; ?>)'>
                                            <button class="btn btn-danger">
                                                Delete
                                            </button>
                                        </a>
                                    </div>
                                    <div class="mb-1">
                                        <a class="print-client text-light" style="text-decoration: none;"
                                            href='<?php echo "./view_client.php?id=" . $row['id'] . "&mode=print" ?>'>
                                            <button class="btn btn-info">
                                                Share
                                            </button>
                                        </a>
                                    </div>
                                </div>


                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<script>
    const sendRequest = (operation, clientId) => {
        if (operation == "delete") {
            deleteClient(clientId);
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

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('searchName').addEventListener('input', function () {
            filterTableByName(this.value.toLowerCase());
        });

        function filterTableByName(searchTerm) {
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

                if (name.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    });
</script>