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

    $sql = "SELECT users.*, 
        CONCAT( 
            UCASE(LEFT(matchmakers.first_name, 1)), SUBSTRING(matchmakers.first_name, 2)
            , ' ', 
            UCASE(LEFT(matchmakers.last_name, 1)), SUBSTRING(matchmakers.last_name, 2) 
        ) as full_name 
        FROM users 
        LEFT JOIN matchmakers 
        ON (users.id = matchmakers.user_id) 
        WHERE users.id = :id;";

    // $sql = "SELECT * FROM users WHERE id = :id";
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

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0;
        /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    .custom-outline {
        outline: 2px solid #007bff;
        /* Change the color and width as needed */
    }
</style>

<div class="container">
    <main>
        <div class="text-center">
            <p class="fs-3 mb-3">
                View Matchmaker Detail
            </p>
            <!-- <div class="mb-3"></div> -->
            <hr>
            <small>Outlined items cannot be changed</small>
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
                                    <input type="text" class="form-control custom-outline" id="id" name="id"
                                        placeholder="" value="<?php echo $user['id']; ?>" readonly>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control custom-outline" id="full_name"
                                        name="full_name" placeholder="" value="<?php echo $user['full_name']; ?>"
                                        readonly>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder=""
                                        value="<?php echo $user['email']; ?>">
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder=""
                                        value="<?php echo $user['password']; ?>">
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <label for="status" class="form-label">Status (Authorization)</label>
                                    <input type="number" class="form-control" id="status" name="status" placeholder=""
                                        value="<?php echo $user['status'] ?>">
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-center">
                                        <a id="update" class="text-light" style="text-decoration: none;">
                                            <button class="btn btn-info">
                                                Update
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="fs-4">
                                        Status Information:
                                    </p>
                                    <hr>
                                    <p>Set STATUS to 0 to block/deauthorize user of their rights</p>
                                    <p>Set STATUS to 1 to allow/authorize user of their rights</p>
                                    <hr>
                                    <p>
                                        If STATUS is 0, the user IS NOT authorized to use the system. The user cannot
                                    <ul>
                                        <li>Log in</li>
                                        <li>View any pages</li>
                                        <li>Use any functions</li>
                                    </ul>
                                    </p>
                                    <p>
                                        If STATUS is 1, the user IS authorized to use the system. The user can
                                    <ul>
                                        <li>Log in</li>
                                        <li>Create View Update and delete respective client records</li>
                                        <li>Use relevant functions</li>
                                    </ul>
                                    </p>
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
    // onclick='sendRequest(<?php //echo $user["id"]; ?>)'
    const validateForm = () => {
        console.log("Starting validation");
        let email = $('#email').val();
        let password = $('#password').val();
        let status = $('#status').val();

        console.log('email: ' + email);
        console.log('password: ' + password);
        console.log('status type: ' + typeof (status));
        console.log('status: ' + status);
        let errorList = [];

        console.log("Starting validation");

        if (email == "") {
            console.log("Email is empty")
            errorList.push("Email cannot be empty");
            // add invalid class to input
            $('#email').addClass('is-invalid');
            return false;
        }
        if (password == "") {
            console.log("Password is empty")
            errorList.push("Password cannot be empty");
            // add invalid class to input
            $('#password').addClass('is-invalid');
            return false;
        }
        //check length of password
        if (password.length < 8) {
            console.log("Password is too short");
            errorList.push("Password must be at least 8 characters long");
            // add invalid class to input
            $('#password').addClass('is-invalid');
            return false;
        }
        if (Number(status) !== 0 && Number(status) !== 1) {
            console.log("Status is invalid");
            errorList.push("Status must be either 0 or 1");
            // add invalid class to input
            $('#status').addClass('is-invalid');
            return false;
        }

        errorList.forEach(error => {
            $('#errorList').append('<li>' + error + '</li>');
        });

        if (errorList.length > 0) {
            $('#error_alert').removeClass('d-none');
        }

        // console.log("Validation successful");
        return true;
    }

    $('#update').click(function (e) {
        e.preventDefault();
        if (!validateForm()) {
            console.log("Validation error");
            return;
        } else {
            // remove invalid class from input

            $('#email').removeClass('is-invalid');
            $('#password').removeClass('is-invalid');
            $('#status').removeClass('is-invalid');

            let clientId = $('#id').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let status = $('#status').val();

            $.ajax({
                url: "update_user.php",
                type: "POST",
                data: {
                    id: clientId,
                    email: email,
                    password: password,
                    status: status
                },
                success: function (data) {
                    if (data === "success") {
                        alert('User updated successfully');
                        // redirect to dashboard
                        window.location.href = "dashboard.php";
                    } else {
                        alert('User could not be updated');
                    }
                },
                error: function (e) {
                    alert(e);
                }
            });
        }
    });
</script>