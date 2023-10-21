<!-- matchmakers/dashboard.php -->
<?php
include(__DIR__ . '/../session.php');
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/navbar.php');
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
</style>

<div class="container">
    <main>
        <div class="text-center">
            <h2>Add Client Info</h2>
            <small>All fields are required</small>
            <div class="mb-3"></div>
        </div>
        <div class="row g-5">
            <form id="client_form">
                <div class="d-flex justify-content-center">
                    <div class="col-md-7 col-lg-8">
                        <div class="row g-3">
                            <div class="alert alert-danger alert-dismissible d-none fade show" id="error_alert"
                                role="alert">
                                <div id="errorList"></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <div class="col-sm-6">
                                <label for="first_name" class="form-label">First name</label>
                                <input type="text" class="form-control" id="first_name" placeholder="" value=""
                                    maxlength="50" minlength="3" >
                            </div>

                            <div class="col-sm-6">
                                <label for="last_name" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="last_name" placeholder="" value=""
                                    maxlength="50" minlength="3" >
                            </div>

                            <div class="col-3">
                                <label for="dob" class="form-label">DOB</label>
                                <input type="date" class="form-control" id="dob" placeholder="" value="" >
                            </div>

                            <div class="col-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-control" >
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <label for="education" class="form-label">Education</label>
                                <input type="text" class="form-control" id="education" maxlength="100" minlength="3"
                                    value="" placeholder="">
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" value="" placeholder="1234 Main St"
                                    maxlength="100" minlength="3" >
                            </div>

                            <div class="col-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" class="form-control" id="occupation" value="" placeholder=""
                                    maxlength="100" minlength="3" >
                            </div>

                            <div class="col-3">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="number" class="form-control" id="contact" value="" placeholder="">
                            </div>

                            <div class="col-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="90" rows="5"
                                    maxlength="400" minlength="5"></textarea>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-3">
                                <input type="file" id="image" name="image" accept="image/*" >
                            </div>
                            <div class="col"></div>
                            <div class="col-8">
                                <img id="imagePreview" src="#" alt="Image Preview"
                                    style="max-width: 100%; display: none;">
                            </div>
                        </div>
                        <hr class="my-4">
                        <button class="w-100 btn btn-primary btn-lg" id="form_submit" type="submit">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer class="my-5">

    </footer>
</div>

<?php include(__DIR__ . '/../includes/footer.php'); ?>

<script>
    document.getElementById('image').addEventListener('change', function () {
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function () {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        }

        reader.readAsDataURL(file);
    });

    const clearPage = () => {
        // Reset input fields
        $('#client_form')[0].reset();

        // Reset image preview
        $('#imagePreview').attr('src', '').hide();

        // Reset file input (optional)
        $('#image').val('');
    }

    // Function to validate the client form
    function validateClientForm() {
        let errorList = document.getElementById("errorList");
        // .classList.remove("d-none");

        console.log("Validating client form");
        errorList.value = "";

        const firstName = $("#first_name").val();
        const lastName = $("#last_name").val();
        const dob = $("#dob").val();
        // const gender = $("#gender").val();
        const education = $("#education").val();
        const address = $("#address").val();
        const occupation = $("#occupation").val();
        const contact = $("#contact").val();

        const currentDate = new Date();
        const selectedDate = new Date(dob);

        // Regular expressions for validation
        const nameRegex = /^[a-zA-Z\s]+$/;
        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        const contactRegex = /^\d{11}$/;

        // Validation flags
        let isValid = true;

        // Validate first name
        if (!nameRegex.test(firstName) || firstName.length < 3) {
            isValid = false;
            errorList.innerHTML += "Please enter a valid first name (at least 3 characters, alphabets only)." + "<br>";
        }

        // Validate last name
        if (!nameRegex.test(lastName) || lastName.length < 3) {
            isValid = false;
            errorList.innerHTML += "Please enter a valid last name (at least 3 characters, alphabets only)." + "<br>";
        }

        // Validate date of birth
        if (!dateRegex.test(dob)) {
            isValid = false;
            errorList.innerHTML += "Please enter a valid date of birth (YYYY-MM-DD format)." + "<br>";
        }

        if (!contactRegex.test(contact)) {
            isValid = false;
            errorList.innerHTML += "Please enter a valid contact number (11 digits)." + "<br>";
        }

        if(!education || education.length < 3){
            console.log("education: ", education);
            console.log("education len: ",education.length);
            isValid = false;
            errorList.innerHTML += "Please enter a valid education (at least 3 characters)." + "<br>";
        }

        if(!address || address.length < 3){
            isValid = false;
            errorList.innerHTML += "Please enter a valid address (at least 3 characters)." + "<br>";
        }

        if(!occupation || occupation.length < 3){
            isValid = false;
            errorList.innerHTML += "Please enter a valid occupation (at least 3 characters)." + "<br>";
        }

        if (selectedDate >= currentDate) {
            isValid = false;
            errorList.innerHTML += 'Please select a date before the current date.' + "<br>";
        }

        if(!isValid){
            document.getElementById('error_alert').classList.remove("d-none");
        }

        return isValid;
    }

    document.getElementById('client_form').addEventListener('submit', function (event) {
        if (!validateClientForm()) {
            console.log("Form validation failed");
            event.preventDefault();
        } else {
            console.log("Submitting form");
            event.preventDefault();
            const image = $('#image');
            const image_data = image.prop('files')[0]; //gets the image, [1] is the length

            const first_name = $('#first_name').val();
            const last_name = $('#last_name').val();

            let DOB = new Date($('#dob').val());
            const day = DOB.getDate();
            const month = DOB.getMonth() + 1;
            const year = DOB.getFullYear();
            DOB = [year, month, day].join('-');

            const gender = $('#gender').val();
            const education = $('#education').val();
            const occupation = $('#occupation').val();
            const address = $('#address').val();
            const contact = $('#contact').val();
            const description = $('#description').val();

            const formData = new FormData();
            formData.append('first_name', first_name);
            formData.append('last_name', last_name);
            formData.append('DOB', DOB);
            formData.append('gender', gender);
            formData.append('education', education);
            formData.append('occupation', occupation);
            formData.append('address', address);
            formData.append('contact', contact);
            formData.append('description', description);
            formData.append('image', image_data);

            $.ajax({
                url: "process_form.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    if (data == "success") {
                        alert('Image Uploaded successfully');
                    } else if (data == "fakeImgError") {
                        alert("Image uploaded is fake");
                    } else if (data == "existingRecord") {
                        alert('Client already exists');
                    } else if (data == "fileError") {
                        alert("Error uploading file");
                    } else if (data == "extError") {
                        alert('File image format other than jpg, jpeg, png, gif not allowed');
                    } else if (data == "sizeError") {
                        alert('File size larger than 5MB not allowed');
                    }
                    clearPage();
                },
                error: function (e) {
                    alert(e);
                }
            });
        }
    });
</script>