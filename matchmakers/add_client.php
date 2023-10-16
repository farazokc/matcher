<!-- matchmakers/dashboard.php -->
<?php
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/navbar.php');
include(__DIR__ . '/../session.php');
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
        <div class="py-5 text-center">
            <h2>Add Client Info</h2>
        </div>
        <div class="row g-5">
            <form id="client_form">
                <div class="d-flex justify-content-center">
                    <div class="col-md-7 col-lg-8">
                        <!-- <h4 class="mb-3"></h4> -->
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label for="first_name" class="form-label">First name</label>
                                <input type="text" class="form-control" id="first_name" placeholder="" value="asd"
                                    required>
                            </div>

                            <div class="col-sm-6">
                                <label for="last_name" class="form-label">Last name</label>
                                <input type="text" class="form-control" id="last_name" placeholder="" value="asd"
                                    required>
                            </div>

                            <div class="col-3">
                                <label for="DOB" class="form-label">DOB</label>
                                <input type="date" class="form-control" id="DOB" placeholder="DOB" value="2017-06-01"
                                    required>
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
                                <input type="text" class="form-control" id="education" value="asd" placeholder="">
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" value="asd"
                                    placeholder="1234 Main St" required>
                            </div>

                            <div class="col-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" class="form-control" id="occupation" value="asd" placeholder="">
                            </div>

                            <div class="col-3">
                                <label for="income" class="form-label">Income</label>
                                <input type="number" class="form-control" id="income" value="123" placeholder="">
                            </div>

                            <div class="col-6">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" cols="90"
                                    rows="5">Default</textarea>
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

    // $('#client_form').on('submit', function (event) {
    document.getElementById('client_form').addEventListener('submit', function (event) {
        event.preventDefault();
        var image = $('#image');
        var image_data = image.prop('files')[0]; //gets the image, [1] is the length

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        
        var DOB = new Date($('#DOB').val());
        // var day = DOB.getDate();
        // var month = DOB.getMonth() + 1;
        // var year = DOB.getFullYear();
        // DOB = [day, month, year].join('-');

        var gender = $('#gender').val();
        var education = $('#education').val();
        var occupation = $('#occupation').val();
        var address = $('#address').val();
        var income = $('#income').val();
        var description = $('#description').val();

        console.log("LOGGING INDIVIDUAL DATA: ")
        console.log("First name: ", first_name);
        console.log("Last name: ", last_name);
        console.log("DOB: ", DOB);
        console.log("Gender", gender);
        console.log("Education: ", education);
        console.log("Occupation: ", occupation);
        console.log("Address: ", address);
        console.log("Income: ", income);
        console.log("Description: ", description);
        console.log("Image prop('files'): ", image.prop('files'));
        console.log("Image data: ", image_data);


        var formData = new FormData();
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
        	contentType:false,
        	cache: false,
        	processData: false,
        	success: function(data){
        		if(data == "success"){
        			alert('Image Uploaded successfully');
        		} else if(data == "fakeImgError") {
                    alert("Image uploaded is fake");
                }else if (data == "existingRecord"){
          			alert('Client already exists');
                }else if(data == "fileError"){
        			alert("Error uploading file");
        		}else if(data == "extError"){
        			alert('File image format other than jpg, jpeg, png, gif not allowed');
        		}else if(data == "sizeError"){
        			alert('File size larger than 5MB not allowed');
        		}
        	},
            error: function(e){
                alert(e);
            }
        });
    });

    // Function to get user ID (replace this with your actual method)
    function getUserId() {

    }


</script>