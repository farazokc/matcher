<!-- matchmakers/dashboard.php -->
<?php
include(__DIR__ . '/../session.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/navbar.php');

// get client ID from URL
if (!isset($_GET['id'])) {
    header("Location: " . __DIR__ . DIRECTORY_SEPARATOR . "dashboard.php");
    exit();
} else {
    $user_id = $_GET['id'];

    // get users information from database
    global $db;
    $sql = "SELECT * FROM users WHERE id = :id";
    $params = [
        ':id' => $user_id
    ];
    $stmt = $db->executePreparedStatement($sql, $params);
    $result = $db->fetchRow($stmt);
    if (!$result) {
        header("Location: " . __DIR__ . DIRECTORY_SEPARATOR . "dashboard.php");
        exit();
    } else {
        $user = $result;
    }
}
?>

<div class="container">
    <main>
        <div class="text-center">
            <p class="fs-3">
                View Matchmaker Detail
            </p>
            <div class="mb-3"></div>
            <hr>
        </div>
        <div class="row g-5">
            <form id="client_form" method="POST">
                <div class="d-flex justify-content-center">
                    <div class="col-sm-9 col-md-7 col-lg-9">
                        <div class="alert alert-danger alert-dismissible d-none fade show" id="error_alert"
                            role="alert">
                            <div id="errorList"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="container">
                            <div class="row g-3">
                                <div class="col-sm-12 col-md-3">
                                    <label for="id" class="form-label">ID</label>
                                    <input type="text" class="form-control" id="id" name="id" placeholder=""
                                        value="<?php echo $user['id']; ?>" readonly>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder=""
                                        value="<?php echo $user['email']; ?>" readonly>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder=""
                                        value="<?php echo $user['password']; ?>" readonly>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="status" name="status" placeholder=""
                                        value="<?php
                                        if ($user['status'] == 0) {
                                            echo "Unauthorized";
                                        } else if ($user['status'] == 1) {
                                            echo "Authorized";
                                        }
                                        ?>" readonly>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        <?php
                                        if ($user['status'] == 0) { ?>
                                            <a class="text-light" style="text-decoration: none;"
                                                onclick='sendRequest("authorize", <?php echo $user["id"]; ?>)'>
                                                <button class="btn btn-success">
                                                    Authorize
                                                </button>
                                            </a>
                                            <?php
                                        } else if ($user['status'] == 1) {
                                            ?>
                                                <a class="text-light" style="text-decoration: none;"
                                                    onclick='sendRequest("deauthorize", <?php echo $user["id"]; ?>)'>
                                                    <button class="btn btn-danger">
                                                        Deauthorize
                                                    </button>
                                                </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer class="my-5"></footer>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

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