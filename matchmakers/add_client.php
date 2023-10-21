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
        </div>
        <div class="row g-5">
            <form id="client_form">
                <div class="d-flex justify-content-center">
                    <div class="col-md-7 col-lg-8">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="first_name" class="form-label">First name</label>
                                <input type="text" class="form-control" id="first_name" placeholder="" value=""
                                    maxlength="50" minlength="3" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="last_name" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="last_name" placeholder="" value=""
                                    maxlength="50" minlength="3" required>
                            </div>

                            <div class="col-3">
                                <label for="dob" class="form-label">DOB</label>
                                <input type="date" class="form-control" id="dob" placeholder="" value="" required>
                            </div>

                            <div class="col-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
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
                                    maxlength="100" minlength="3" required>
                            </div>

                            <div class="col-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" class="form-control" id="occupation" value="" placeholder=""
                                    maxlength="100" minlength="3" required>
                            </div>

                            <div class="col-3">
                                <label for="income" class="form-label">Income</label>
                                <input type="number" class="form-control" id="income" value="" placeholder="">
                            </div>

                            <div class="col-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="90" rows="5"
                                    maxlength="400" minlength="5" required>Default</textarea>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-3">
                                <input type="file" id="image" name="image" accept="image/*" required>
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
        // Get form input values
        var firstName = document.getElementById("first_name").value;
        var lastName = document.getElementById("last_name").value;
        var dob = document.getElementById("dob").value;
        var gender = document.getElementById("gender").value;
        var address = document.getElementById("address").value;

        // Regular expressions for validation
        var nameRegex = /^[a-zA-Z\s]+$/;
        var dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        var incomeRegex = /^\d+(\.\d{1,2})?$/;

        // Validation flags
        var isValid = true;

        // Validate first name
        if (!nameRegex.test(firstName) || firstName.length < 3) {
            isValid = false;
            alert("Please enter a valid first name (at least 3 characters, alphabets only).");
        }

        // Validate last name
        if (!nameRegex.test(lastName) || lastName.length < 3) {
            isValid = false;
            alert("Please enter a valid last name (at least 3 characters, alphabets only).");
        }

        // Validate date of birth
        if (!dateRegex.test(dob)) {
            isValid = false;
            alert("Please enter a valid date of birth (YYYY-MM-DD format).");
        }

        // Validate income (optional)
        var income = document.getElementById("income").value;
        if (income !== "" && !incomeRegex.test(income)) {
            isValid = false;
            alert("Please enter a valid income (numeric, with up to 2 decimal places).");
        }

        // You can add more validations as needed

        return isValid;
    }

    // Attach the validation function to the form's submit event
    document.getElementById("client_form").addEventListener("submit", function (event) {
        if (!validateClientForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });



    document.getElementById('client_form').addEventListener('submit', function (event) {
        event.preventDefault();
        const image = $('#image');
        const image_data = image.prop('files')[0]; //gets the image, [1] is the length

        const first_name = $('#first_name').val();
        const last_name = $('#last_name').val();

        const DOB = new Date($('#dob').val());
        const day = DOB.getDate();
        const month = DOB.getMonth() + 1;
        const year = DOB.getFullYear();
        DOB = [year, month, day].join('-');

        const gender = $('#gender').val();
        const education = $('#education').val();
        const occupation = $('#occupation').val();
        const address = $('#address').val();
        const income = $('#income').val();
        const description = $('#description').val();

        // console.log("LOGGING INDIVIDUAL DATA: ")
        // console.log("First name: ", first_name);
        // console.log("Last name: ", last_name);
        // console.log("DOB: ", DOB);
        // console.log("Gender", gender);
        // console.log("Education: ", education);
        // console.log("Occupation: ", occupation);
        // console.log("Address: ", address);
        // console.log("Income: ", income);
        // console.log("Description: ", description);
        // console.log("Image prop('files'): ", image.prop('files'));
        // console.log("Image data: ", image_data);

        const formData = new FormData();
        formData.append('first_name', first_name);
        formData.append('last_name', last_name);
        formData.append('DOB', DOB);
        formData.append('gender', gender);
        formData.append('education', education);
        formData.append('occupation', occupation);
        formData.append('address', address);
        formData.append('income', income);
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
    });
</script>