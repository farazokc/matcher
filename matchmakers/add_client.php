<!-- matchmakers/dashboard.php -->
<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php');
include(__DIR__ . DIRECTORY_SEPARATOR . 'navbar.php');
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
                Add New Client <small>(<strong style="color: red;">*</strong> are required fields)</small>
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
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="female">Female</option>
                                        <option value="male">Male</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="name" class="form-label"><strong style="color: red;">*
                                        </strong>Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder=""
                                        value="" minlength="3" maxlength="50">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="age" class="form-label"><strong style="color: red;">*
                                        </strong>Age</label>
                                    <select name="age" size="1" id="age" class="form-control">
                                        <option value="" disabled selected>Select an option</option>
                                        <?php for ($i = 18; $i <= 70; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="height" class="form-label"><strong style="color: red;">*
                                        </strong>Height(cm)</label>
                                    <input type="number" class="form-control" id="height" name="height" value=""
                                        placeholder="" min="3" max="500" minlength="1" maxlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="cnic" class="form-label"><strong style="color: red;">*
                                        </strong>CNIC#</label>
                                    <input type="text" class="form-control" id="cnic" placeholder="" name="cnic"
                                        value="" maxlength="13" minlength="13">
                                </div>


                                <div class="col-sm-12 col-md-3">
                                    <label for="cast" class="form-label"><strong style="color: red;">*
                                        </strong>Cast</label>
                                    <input type="text" class="form-control" id="cast" value="" name="cast"
                                        placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="maslak" class="form-label"><strong style="color: red;">*
                                        </strong>Maslak</label>
                                    <input type="text" class="form-control" id="maslak" value="" name="maslak"
                                        placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="Complexion" class="form-label"><strong style="color: red;">*
                                        </strong>Complexion</label>
                                    <input type="text" class="form-control" id="Complexion" value=""
                                        name="complexion" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="marital_status" class="form-label"><strong style="color: red;">*
                                        </strong>Marital Status</label>
                                    <select name="marital_status" id="marital_status" class="form-control">
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="Single">Single / Never married</option>
                                        <option value="Nikkah Break">Nikkah Break</option>
                                        <option value="Separated">Separated</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="div_reason" class="form-label">Divorce reason</label>
                                    <input type="text" class="form-control" name="div_reason" id="div_reason"
                                        maxlength="255" />
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="children" class="form-label"><strong style="color: red;">* </strong># of
                                        children</label>
                                    <input type="number" class="form-control" id="children" name="children" value=""
                                        placeholder="" min="0" max="15">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="education" class="form-label"><strong style="color: red;">*
                                        </strong>Education</label>
                                    <input type="text" class="form-control" id="education" name="education" value=""
                                        placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="job" class="form-label">Job</label>
                                    <input type="text" class="form-control" id="job" value="" name="job"
                                        placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="business" class="form-label">Business</label>
                                    <input type="text" class="form-control" id="business" value=""
                                        name="business" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="income" class="form-label">Income</label>
                                    <input type="number" class="form-control" id="income" value=""
                                        name="income" placeholder="" step="0.01">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="mother_tongue" class="form-label">Mother Tongue</label>
                                    <input type="text" class="form-control" id="mother_tongue" value=""
                                        name="mother_tongue" placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="belongs" class="form-label">Belongs to</label>
                                    <input type="text" class="form-control" id="belongs" value="" name="belongs"
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
                                    <input type="text" class="form-control" id="country" value="" name="country"
                                        placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="province" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="province" value=""
                                        name="province" placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" value="" name="city"
                                        placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="area" class="form-label">Area</label>
                                    <input type="text" class="form-control" id="area" value="" name="area"
                                        placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="family_status" class="form-label">Family Status</label>
                                    <input type="text" class="form-control" id="family_status" value=""
                                        name="family_status" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="full_address" class="form-label">Full Address</label>
                                    <input type="text" class="form-control" id="full_address" value=""
                                        name="full_address" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="home_type" class="form-label">Home Type</label>
                                    <input type="text" class="form-control" id="home_type" value=""
                                        name="home_type" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="home_size" class="form-label">Home size (in yards)</label>
                                    <input type="number" class="form-control" id="home_size" value=""
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
                                    <input type="text" class="form-control" id="father" value=""
                                        name="father" placeholder="" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="mother" class="form-label">Mother</label>
                                    <input type="text" class="form-control" id="mother" value=""
                                        placeholder="" name="mother" maxlength="255">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="brothers" class="form-label">Brothers</label>
                                    <input type="number" class="form-control" id="brothers" value="" placeholder=""
                                        name="brothers">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="sisters" class="form-label">Sisters</label>
                                    <input type="number" class="form-control" id="sisters" value="" placeholder=""
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
                                    <input type="number" class="form-control" id="req_age" value="" placeholder=""
                                        name="req_age">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_cast" class="form-label"><strong style="color: red;">*</strong>
                                        Cast</label>
                                    <input type="text" class="form-control" id="req_cast" value="" placeholder=""
                                        name="req_cast" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_maslak" class="form-label"><strong style="color: red;">*</strong>
                                        Maslak</label>
                                    <input type="text" class="form-control" id="req_maslak" value=""
                                        placeholder="" name="req_maslak" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_height" class="form-label">Height</label>
                                    <input type="number" class="form-control" id="req_height" value="" placeholder=""
                                        name="req_height">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_family_status" class="form-label">Family Status</label>
                                    <input type="text" class="form-control" id="req_family_status" value=""
                                        name="req_family_status" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_marital_status" class="form-label"><strong
                                            style="color: red;">*</strong> Marital Status</label>
                                    <input type="text" class="form-control" id="req_marital_status" value=""
                                        name="req_marital_status" placeholder="" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_education" class="form-label"><strong style="color: red;">*</strong>
                                        Education</label>
                                    <input type="text" class="form-control" id="req_education" value=""
                                        placeholder="" name="req_education" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_city" class="form-label"><strong style="color: red;">*</strong>
                                        City</label>
                                    <input type="text" class="form-control" id="req_city" value=""
                                        placeholder="" name="req_city" maxlength="255" minlength="3">
                                </div>

                                <div class="col-sm-12 col-md-3">
                                    <label for="req_country" class="form-label"><strong style="color: red;">*</strong>
                                        Country</label>
                                    <input type="text" class="form-control" id="req_country" value=""
                                        placeholder="" name="req_country" maxlength="255" minlength="3">
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="row text-center">
                                <p class="fs-4">Select image of client</p>
                                <div class="col-sm-12 col-md-3 mb-5 text-center">
                                    <input type="file" id="image" class="form-control" name="image" accept="image/*">
                                    <!-- <input type="file" id="image" name="image" accept="image/*" multiple> -->
                                </div>
                                <br>
                                <div class="col-sm-12 col-md-9">
                                    <div id="imagePreview"></div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <button class="w-100 btn btn-primary btn-lg" id="form_submit" type="submit">Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<?php include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'); ?>

<script>
    document.getElementById('image').addEventListener('change', function () {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = '';

        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            const reader = new FileReader();

            reader.onload = function () {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.maxWidth = '200px';
                img.style.marginRight = '5px';
                imagePreview.appendChild(img);
            }

            reader.readAsDataURL(file);
        }
    });

    function clearForm() {
        $('#client_form')[0].reset();   // clears form data
        $('#imagePreview').attr('src', '').hide(); // clears image preview
        // $('#image').val('');
        $('#error_alert').hide();   // hides error alert
        $('#errorList').empty();    // clears error list
    }

    function validateClientForm() {
        console.log("Inside validation of form");
        const errorList = [];
        const requiredFields = ['name', 'age', 'gender', 'cnic', 'cast', 'maslak', 'marital_status', 'education', 'req_age', 'req_cast', 'req_maslak', 'req_marital_status', 'req_education', 'req_city', 'req_country', 'image'];

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
            console.log("Submitting form");
            const formData = new FormData(this); // Get form data

            $.ajax({
                url: "add_form.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data === "success") {
                        alert('Record added successfully');
                    } else if (data === "fakeImgError") {
                        alert("Image uploaded is fake");
                    } else if (data === "existingRecord") {
                        alert('Client already exists');
                    } else if (data === "fileError") {
                        alert("Error uploading file");
                    } else if (data === "extError") {
                        alert('File image format other than jpg, jpeg, png, gif not allowed');
                    } else if (data === "sizeError") {
                        alert('File size larger than 5MB not allowed');
                    }
                    clearForm(); // Clear the form after submission
                },
                error: function (e) {
                    alert(e);
                }
            });
        }
    });
</script>