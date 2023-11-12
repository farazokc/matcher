<!-- admin/view_all_clients.php -->
<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');

if (!isset($_SESSION['users_id']) || !isset($_SESSION['users_email'])) {
    // Redirect to login page if not logged in as a matchmaker
    header("Location: " . dirname(__DIR__) . DIRECTORY_SEPARATOR . "index.php");
    exit();
}

include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php');
include(__DIR__ . DIRECTORY_SEPARATOR . 'navbar.php');

global $db;

$user_id = $_SESSION['users_id'];

// Get the matchmaker's ID from clients table
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
</style>

<main>
    <div class="container">
        <h1 class="text-center">All Clients</h1>
        <div class="d-flex justify-content-center align-items-center">
            <div class="col-sm-12 col-md-6 col-lg-3 text-center me-2">
                Filter clients by name:
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <input type="text" class="form-control" id="searchName" placeholder="Enter name">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-3 fs-5 text-center my-3">
                <?php if ($records == []) { ?>
                    No clients have been added
                </div>
            <?php } else { ?>
                Number of total clients:
                <?php echo " " . count($records) ?>
            </div>
            <div class="table-responsive-sm col-12">
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
                            Added by
                        </th>
                        <th>
                            Actions
                        </th>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $row) { ?>
                            <tr>
                                <td>
                                    <img src="<?php echo "./../" . $row['photo_path'] ?>" alt="Image"
                                        style="max-width: 150px; max-height: 150px;">
                                </td>
                                <td>
                                    <?php echo ucfirst($row['name']); ?>
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
                                    <?php echo round($row['cnic']); ?>
                                </td>
                                <td>
                                    <?php echo $row['matchmaker_name']; ?>
                                </td>
                                <td style="width: 100px;">
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <a class="view-client text-light" style="text-decoration: none;"
                                                href='<?php echo "./view_client.php?id=" . $row['id'] . "&mode=view" ?>'>
                                                <button class="btn btn-primary" style="width:100%;">
                                                    View
                                                </button>
                                            </a>
                                        </div>

                                        <div class="col-12 mb-1">
                                            <a class="edit-client text-light" style="text-decoration: none;"
                                                href="<?php echo "./edit_client.php?id=" . $row['id'] ?>">
                                                <button class="btn btn-warning" style="width:100%;">
                                                    Edit
                                                </button>
                                            </a>
                                        </div>

                                        <div class="col-12 mb-1">
                                            <a class="delete-client text-light" style="text-decoration: none;"
                                                onclick='sendRequest("delete", <?php echo $row["id"]; ?>)'>
                                                <button class="btn btn-danger" style="width:100%;">
                                                    Delete
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <a class="print-client text-light" style="text-decoration: none;"
                                                href='<?php echo "./view_client.php?id=" . $row['id'] . "&mode=print" ?>'>
                                                <button class="btn btn-info" style="width:100%;">
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
</main>

<?php include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'); ?>

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