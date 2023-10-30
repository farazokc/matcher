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

$sql = "SELECT users.*, 
        CONCAT( 
            UCASE(LEFT(matchmakers.first_name, 1)), SUBSTRING(matchmakers.first_name, 2)
            , ' ', 
            UCASE(LEFT(matchmakers.last_name, 1)), SUBSTRING(matchmakers.last_name, 2) 
        ) as full_name 
        FROM users 
        LEFT JOIN matchmakers 
        ON (users.id = matchmakers.user_id) 
        WHERE users.status IN (0, 1) 
        ORDER BY users.status ASC;";

$params = [];
$stmt = $db->executePreparedStatement($sql, $params);
$result = $db->fetchAll($stmt);


?>
<style>
    button a {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Inherit color from parent element (button) */
    }
</style>

<div class="container">
    <h1 class="text-center">All Matchmakers</h1>
    <div class="d-flex justify-content-center align-items-center mb-3">
        <div class="col-sm-12 col-md-6 col-lg-3 text-center me-2">
            Filter users by name:
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3">
            <input type="text" class="form-control" id="searchName" placeholder="Enter name">
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-sm-12 col-md-6 col-lg-3 text-center me-2">
            Filter users by email:
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3">
            <input type="text" class="form-control" id="searchEmail" placeholder="Enter email">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-3 fs-5 text-center mb-3">
            <?php if ($result == []) { ?>
                No users have been added
            </div>
        <?php } else { ?>
            Number of total users:
            <?php echo " " . count($result) ?>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped-columns align-middle fs-6 text-center">
                <thead>
                    <th>
                        ID
                    </th>
                    <th>
                        Name
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
                                <?php echo $row['full_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['email'] ?>
                            </td>
                            <?php if ($row['status']) { ?>
                                <td>
                                    <strong>
                                        Active
                                    </strong>
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
        </div>
    </div>
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

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('searchEmail').addEventListener('input', function () {
            filterTableByEmail(this.value.toLowerCase());
        });

        function filterTableByEmail(searchTerm) {
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                if (email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    });

</script>

<?php include(__DIR__ . '/../includes/footer.php'); ?>