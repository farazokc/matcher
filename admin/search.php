<!-- 
        Gender                  DONE
        Age from to             DONE
        Marital status          DONE
    Caste                   DONE
    City                    DONE
        Min height max height   DONE
-->
<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php');
include(__DIR__ . DIRECTORY_SEPARATOR . 'navbar.php');

global $db;

// get all unique castes
$sql_castes = "SELECT DISTINCT cast FROM clients";
$params_castes = [];

$stmt_castes = $db->executePreparedStatement($sql_castes, $params_castes);
$row_castes = $db->fetchAll($stmt_castes);

// convert array to string
$row_castes = array_map(function ($value) {
    return $value['cast'];
}, $row_castes);


// get all cities
$sql_city = "SELECT DISTINCT city FROM clients";
$params_city = [];

$stmt_city = $db->executePreparedStatement($sql_city, $params_city);
$row_city = $db->fetchAll($stmt_city);

$row_city = array_map(function ($value) {
    return $value['city'];
}, $row_city);


// get all countries
$sql_country = "SELECT DISTINCT country FROM clients";
$params_country = [];

$stmt_country = $db->executePreparedStatement($sql_country, $params_country);
$row_country = $db->fetchAll($stmt_country);

$row_country = array_map(function ($value) {
    return $value['country'];
}, $row_country);


// get all education
$sql_education = "SELECT DISTINCT education FROM clients";
$params_education = [];

$stmt_education = $db->executePreparedStatement($sql_education, $params_education);
$row_education = $db->fetchAll($stmt_education);

$row_education = array_map(function ($value) {
    return $value['education'];
}, $row_education);
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
            <h1>Search</h1>
            <hr>
        </div>
        <div class="row g-5">
            <form id="search" method="POST">
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
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="" selected>Select an option</option>
                                        <option value="female">Female</option>
                                        <option value="male">Male</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="age" class="form-label">Age</label>
                                    <select name="age" size="1" id="age" class="form-control">
                                        <option value="" selected>Select an option</option>
                                        <?php for ($i = 18; $i <= 70; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="education" class="form-label">Education</label>
                                    <select name="education" size="1" id="education" class="form-control">
                                        <option value="" selected>Select an option</option>
                                        <?php foreach ($row_education as $key => $value) {
                                            echo "<option value='$value'>$value</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="marital_status" class="form-label">Marital Status</label>
                                    <select name="marital_status" id="marital_status" class="form-control">
                                        <option value="" selected>Select an option</option>
                                        <option value="Single">Single / Never married</option>
                                        <option value="Nikkah Break">Nikkah Break</option>
                                        <option value="Separated">Separated</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="city" class="form-label">City</label>
                                    <select name="city" size="1" id="city" class="form-control">
                                        <option value="" selected>Select an option</option>
                                        <?php foreach ($row_city as $key => $value) {
                                            echo "<option value='$value'>$value</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select name="country" size="1" id="country" class="form-control">
                                        <option value="" selected>Select an option</option>
                                        <?php foreach ($row_country as $key => $value) {
                                            echo "<option value='$value'>$value</option>";
                                        } ?>
                                    </select>
                                </div>

                                <button class="w-100 btn btn-primary btn-lg" id="form_submit"
                                    type="submit">Search</button>
                                <div class="my-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Div for showing search results: -->
        <div class="row g-5 d-none fade show" id="results">
            <div class="col-sm-12 col-md-6 col-lg-3 fs-5 text-center my-3" id="notFound">
                No results found
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3 fs-5 text-center my-3" id="resultFound">
                Results found
            </div>
            <div class="table-responsive-sm col-12">
                <table class="table table-hover table-striped-columns align-middle fs-5 text-center">
                    <thead>
                        <th>
                            Name
                        </th>
                        <th>
                            Gender
                        </th>
                        <th>
                            Age
                        </th>
                        <th>
                            Marital Status
                        </th>
                        <th>
                            Education
                        </th>
                        <th>
                            City
                        </th>
                        <th>
                            Country
                        </th>
                        <th>
                            Action
                        </th>
                    </thead>
                    <tbody id="result_tbody">
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'); ?>

<script>
    document.getElementById('search').addEventListener('submit', function (event) {
        event.preventDefault();
        // if (!validateClientForm()) {
        //     alert("Invalid search query. Please correct errors");
        // } else {
        const tbody = document.getElementById('result_tbody');
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }

        document.getElementById('notFound').classList.add('d-none');
        document.getElementById('resultFound').classList.add('d-none');
        document.getElementById('results').classList.add('d-none');

        const formData = new FormData(this); // Get form data

        $.ajax({
            url: "search_form.php",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                json_data = JSON.parse(data);

                if (json_data.length === 0) {
                    document.getElementById('notFound').classList.remove('d-none');
                    document.getElementById('resultFound').classList.add('d-none');
                    document.getElementById('results').classList.remove('d-none');
                    return;
                } else {
                    const tbody = document.getElementById('result_tbody');
                    const columns = ['name', 'gender', 'age', 'marital_status', 'education', 'city', 'country'];


                    json_data.forEach(function (row) {
                        // loop over each field in the row
                        const newRow = document.createElement('tr');
                        columns.forEach(function (column) {
                            const cell = document.createElement('td');
                            cell.innerHTML = `${row[column]}`;
                            newRow.appendChild(cell);
                        });

                        const cell = document.createElement('td');
                        cell.innerHTML = `<div><a href="view_client.php?id=${row['id']}&mode=view" class="btn btn-primary">View</a></div>`;
                        newRow.appendChild(cell);

                        tbody.appendChild(newRow);

                        document.getElementById('notFound').classList.add('d-none');
                        document.getElementById('resultFound').classList.remove('d-none');
                        document.getElementById('results').classList.remove('d-none');
                    })
                }
            },
            error: function (e) {
                alert(e);
            }
        });
        // }
    });
</script>