<!-- matchmakers/dashboard.php -->
<?php
include(__DIR__ . '/../session.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/navbar.php');

if (!isset($_GET['id'])) {
    header('Location: view_all.php');
    exit();
} else {
    global $db;

    $id = $_GET['id'];
    $sql = "SELECT * FROM clients WHERE id = :id";
    $params = [
        'id' => $id
    ];
    $stmt = $db->executePreparedStatement($sql, $params);
    $client = $db->fetchRow($stmt);

    // get current user's matchmaker id
    $sql_mm_id = "SELECT matchmakers.id 
            FROM matchmakers
            JOIN users ON matchmakers.user_id = users.id
            WHERE users.id = :id";

    $params_mm_id = [
        'id' => $_SESSION['users_id']
    ];

    $stmt_mm_id = $db->executePreparedStatement($sql_mm_id, $params_mm_id);
    $mm_id = $db->fetchRow($stmt_mm_id);


    // echo "Matchmaker ID: " . $client['matchmaker_id'] . "<br>";
    // echo "mm_id: " . $mm_id['id'] . "<br>";

    if (!$client) {
        header('Location: view_all.php');
        exit();
    } else if ($client['matchmaker_id'] != $mm_id['id']) {
        header('Location: view_all.php');
        exit();
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

    /* div {
        outline: 1px solid red;
    } */

    select option {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }
</style>

<div class="container">
    <main>
        <div class="text-center">
            <p class="fs-3">
                Edit Client <small>(<strong style="color: red;">*</strong> are required fields)</small>
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
                                <div class="col-12">
                                    <div class="section text-center">
                                        <p class="fs-4">Personal details</p>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="gender" class="form-label"><strong style="color: red;">*</strong>
                                        Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <?php if ($client['gender'] == "Female") {
                                            ?>
                                            <option value="" disabled>Select an option</option>
                                            <option value="female" selected>Female</option>
                                            <option value="male">Male</option>
                                            <?php
                                        } else if ($client['gender'] == "Male") {
                                            ?>
                                                <option value="" disabled>Select an option</option>
                                                <option value="female">Female</option>
                                                <option value="male" selected>Male</option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="name" class="form-label"><strong style="color: red;">*
                                        </strong>Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder=""
                                        value="<?php echo $client['name'] ?>" minlength="3" maxlength="50">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="age" class="form-label"><strong style="color: red;">*
                                        </strong>Age</label>
                                    <select name="age" size="1" id="age" class="form-control">
                                        <option value="" disabled selected>Select an option</option>
                                        <?php for ($i = 18; $i <= 70; $i++) {
                                            if ($client['age'] == $i)
                                                echo "<option value='$i' selected>$i</option>";
                                            else
                                                echo "<option value='$i'>$i</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="height" class="form-label"><strong style="color: red;">*
                                        </strong>Height(cm)</label>
                                    <input type="number" class="form-control" id="height" name="height"
                                        value="<?php echo $client['height'] ?>" placeholder="" min="3" max="500"
                                        minlength="1" maxlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="cnic" class="form-label"><strong style="color: red;">*
                                        </strong>CNIC#</label>
                                    <input type="text" class="form-control" id="cnic" placeholder="" name="cnic"
                                        value="<?php echo $client['cnic'] ?>" maxlength="13" minlength="13">
                                </div>


                                <div class="col-sm-12 col-md-3">
                                    <label for="cast" class="form-label"><strong style="color: red;">*
                                        </strong>Cast</label>
                                    <input type="text" class="form-control" id="cast"
                                        value="<?php echo $client['cast'] ?>" name="cast" placeholder="" maxlength="255"
                                        minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="maslak" class="form-label"><strong style="color: red;">*
                                        </strong>Maslak</label>
                                    <input type="text" class="form-control" id="maslak"
                                        value="<?php echo $client['maslak'] ?>" name="maslak" placeholder=""
                                        maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="Complexion" class="form-label"><strong style="color: red;">*
                                        </strong>Complexion</label>
                                    <input type="text" class="form-control" id="Complexion"
                                        value="<?php echo $client['complexion'] ?>" name="complexion" placeholder=""
                                        maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="marital_status" class="form-label"><strong style="color: red;">*
                                        </strong>Marital Status</label>
                                    <select name="marital_status" id="marital_status" class="form-control">
                                        // generate options
                                        <?php
                                        $marital_status = $client['marital_status'];
                                        $marital_status_options = array("Single", "Nikkah Break", "Separated", "Widowed", "Divorced");

                                        echo '<option value="" disabled selected>Select an option</option>';
                                        foreach ($marital_status_options as $option) {
                                            if ($marital_status == $option) {
                                                echo "<option value='$option' selected>$option</option>";
                                            } else {
                                                echo "<option value='$option'>$option</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="div_reason" class="form-label">Divorce reason</label>
                                    <input type="text" class="form-control" name="div_reason" id="div_reason"
                                    value="<?php echo $client['div_reason'] ?>"
                                        maxlength="255" />
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="children" class="form-label"><strong style="color: red;">* </strong># of
                                        children</label>
                                    <input type="number" class="form-control" id="children" name="children" value="<?php echo $client['children'] ?>"
                                    placeholder="" min="0" max="15">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="education" class="form-label"><strong style="color: red;">*
                                        </strong>Education</label>
                                    <input type="text" class="form-control" id="education" name="education" value="<?php echo $client['education'] ?>"
                                    placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="job" class="form-label">Job</label>
                                    <input type="text" class="form-control" id="job" value="<?php echo $client['job'] ?>" name="job"
                                    placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="business" class="form-label">Business</label>
                                    <input type="text" class="form-control" id="business" value="<?php echo $client['business'] ?>"
                                        name="business" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="income" class="form-label">Income</label>
                                    <input type="number" class="form-control" id="income" value="<?php echo $client['income'] ?>"
                                        name="income" placeholder="" step="0.01">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="mother_tongue" class="form-label">Mother Tongue</label>
                                    <input type="text" class="form-control" id="mother_tongue" value="<?php echo $client['mother_tongue'] ?>"
                                        name="mother_tongue" placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="belongs" class="form-label">Belongs to</label>
                                    <input type="text" class="form-control" id="belongs" value="<?php echo $client['belongs'] ?>" name="belongs"
                                    placeholder="" maxlength="255">
                                </div>

                                <hr>

                                <div class="col-12">
                                    <div class="section text-center">
                                        <p class="fs-4">Residence details</p>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" value="<?php echo $client['country'] ?>" name="country"
                                    placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="province" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="province" value="<?php echo $client['province'] ?>"
                                    name="province" placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" value="<?php echo $client['city'] ?>" name="city"
                                        placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="area" class="form-label">Area</label>
                                    <input type="text" class="form-control" id="area" value="<?php echo $client['area'] ?>" name="area"
                                        placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="family_status" class="form-label">Family Status</label>
                                    <input type="text" class="form-control" id="family_status" value="<?php echo $client['family_status'] ?>"
                                        name="family_status" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="full_address" class="form-label">Full Address</label>
                                    <input type="text" class="form-control" id="full_address" value="<?php echo $client['full_address'] ?>"
                                        name="full_address" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="home_type" class="form-label">Home Type</label>
                                    <input type="text" class="form-control" id="home_type" value="<?php echo $client['home_type'] ?>"
                                    name="home_type" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="home_size" class="form-label">Home size (in yards)</label>
                                    <input type="number" class="form-control" id="home_size" value="<?php echo $client['home_size'] ?>"
                                    name="home_size" placeholder="" min="0" max="50000">
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div class="section text-center">
                                        <p class="fs-4">Family details</p>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="father" class="form-label">Father</label>
                                    <input type="text" class="form-control" id="father" value="<?php echo $client['father'] ?>"
                                    name="father" placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="mother" class="form-label">Mother</label>
                                    <input type="text" class="form-control" id="mother" value="<?php echo $client['mother'] ?>"
                                    placeholder="" name="mother" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="brothers" class="form-label">Brothers</label>
                                    <input type="number" class="form-control" id="brothers" value="<?php echo $client['brothers'] ?>" placeholder=""
                                        name="brothers">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="sisters" class="form-label">Sisters</label>
                                    <input type="number" class="form-control" id="sisters" value="<?php echo $client['sisters'] ?>" placeholder=""
                                        name="sisters">
                                </div>
                                <hr>
                                <div class="col-12">
                                    <div class="section text-center">
                                        <p class="fs-4">Requirements</p>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_age" class="form-label"><strong style="color: red;">*</strong>
                                        Age</label>
                                    <input type="number" class="form-control" id="req_age" value="<?php echo $client['req_age'] ?>" placeholder=""
                                        name="req_age">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_cast" class="form-label"><strong style="color: red;">*</strong>
                                        Cast</label>
                                    <input type="text" class="form-control" id="req_cast" value="<?php echo $client['req_cast'] ?>" placeholder=""
                                    name="req_cast" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_maslak" class="form-label"><strong style="color: red;">*</strong>
                                        Maslak</label>
                                    <input type="text" class="form-control" id="req_maslak" value="<?php echo $client['req_maslak'] ?>"
                                    placeholder="" name="req_maslak" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_height" class="form-label">Height</label>
                                    <input type="number" class="form-control" id="req_height" value="<?php echo $client['req_height'] ?>" placeholder=""
                                    name="req_height">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_family_status" class="form-label">Family Status</label>
                                    <input type="text" class="form-control" id="req_family_status" value="<?php echo $client['req_family_status'] ?>"
                                    name="req_family_status" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_marital_status" class="form-label"><strong
                                            style="color: red;">*</strong> Marital Status</label>
                                    <input type="text" class="form-control" id="req_marital_status" value="<?php echo $client['req_marital_status'] ?>"
                                        name="req_marital_status" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_education" class="form-label"><strong style="color: red;">*</strong>
                                        Education</label>
                                    <input type="text" class="form-control" id="req_education" value="<?php echo $client['req_education'] ?>"
                                        placeholder="" name="req_education" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_city" class="form-label"><strong style="color: red;">*</strong>
                                        City</label>
                                    <input type="text" class="form-control" id="req_city" value="<?php echo $client['req_city'] ?>"
                                        placeholder="" name="req_city" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_country" class="form-label"><strong style="color: red;">*</strong>
                                        Country</label>
                                    <input type="text" class="form-control" id="req_country" value="<?php echo $client['req_country'] ?>"
                                        placeholder="" name="req_country" maxlength="255" minlength="3">
                                </div>
                            </div>
                            <hr class="my-4">
                            <button class="w-100 btn btn-primary btn-lg" id="form_submit" type="submit">Update</button>
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
    function validateClientForm() {
        console.log("Inside validation of form");
        const errorList = [];
        const requiredFields = ['name', 'age', 'gender', 'cnic', 'cast', 'maslak', 'marital_status', 'education', 'req_age', 'req_cast', 'req_maslak', 'req_marital_status', 'req_education', 'req_city', 'req_country'];

        requiredFields.forEach(function (field) {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                let splitField = field.split('_');
                console.log("Split fields:" + splitField);

                if (splitField[0] === 'req') {
                    splitField[0] = 'Requirement';
                }

                splitField.forEach((element, index) => {
                    splitField[index] = element.charAt(0).toUpperCase() + element.slice(1);
                });

                splitField = splitField.join(' ');
                errorList.push(splitField + ' is required.');
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        // validate CNIC
        const cnicInput = document.getElementById('cnic');
        if (!/^\d{13}$/.test(cnicInput.value.trim())) {
            errorList.push('CNIC must be exactly 13 digits.');
            cnicInput.classList.add('is-invalid');
        } else {
            cnicInput.classList.remove('is-invalid');
        }

        let errorAlert = document.getElementById('error_alert');
        let errorListContainer = document.getElementById('errorList');

        if (errorList.length > 0) {
            errorListContainer.innerHTML = '';
            errorList.forEach(function (error) {
                errorListContainer.innerHTML += '<div>' + error + '</div>';
            });
            errorAlert.classList.remove('d-none');
            return false;
        } else {
            errorAlert.classList.add('d-none');
            return true;
        }
    }

    document.getElementById('client_form').addEventListener('submit', function (event) {
        event.preventDefault();
        if (!validateClientForm()) {
            console.log("Form validation failed");
        } else {
            const confirmation = confirm("Are you sure you want to update this record?");
            if (!confirmation) {
                return;
            }
            
            const formData = new FormData(this); // Get form data
            formData.append('client_id', <?php echo $client['id'] ?>);

            console.log("Form data: " + formData);
            $.ajax({
                url: "update_form.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data === "success") {
                        alert('Record updated successfully');
                        window.location.href = "view_all.php";
                    } else if (data === "error") {
                        alert('Error updating record');
                    }
                },
                error: function (e) {
                    alert(e);
                }
            });
        }
    });
</script>