<style>
<?php include('./index.css'); ?>
</style>

<?php include('includes' . DIRECTORY_SEPARATOR . 'header.php'); ?>

<div class="d-flex align-items-center py-4 h-60">
    <main class="form-signin w-100 m-auto">
        <form action="register_process.php" method="POST" onsubmit="return validateForm();">
            <a href="register.php" class="nav-link px-2 link-secondary">
                <img src="admin\admin.png" alt="admin" width=220 height=60>
            </a>
            <h1 class="h3 mb-3 fw-normal"></h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name"
                    required maxlength="50" minlength="3">
                <label for="first_name">First name</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required
                    maxlength="50" minlength="3">
                <label for="last_name">Last name</label>
            </div>

            <div class="form-floating">
                <input type="number" class="form-control" id="phone" name="phone" placeholder="03123456789"
                    maxlength="11" minlength="11" placeholder="" required>
                <label for="phone">Phone (03123456789)</label>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="user@email.com" required
                    maxlength="50">
                <label for="email">Email address (user@email.com)</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="" required
                    maxlength="50">
                <label for="password">Password</label>
            </div>
            <div class="redirect-link">
                <p>Already a member? <a href="index.php">Login!</a></p>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
        </form>
    </main>
</div>
<?php include('includes' . DIRECTORY_SEPARATOR . 'footer.php'); ?>

<script>
    function validateForm() {
        // Get form elements
        var firstName = document.getElementById('first_name').value;
        var lastName = document.getElementById('last_name').value;
        var phone = document.getElementById('phone').value;

        // Regular expression to allow only digits for phone number
        var phoneRegex = /^\d+$/;

        // Check phone number format
        if (!phone.match(phoneRegex)) {
            alert('Phone number should contain only digits.');
            return false;
        }

        // Check first name length
        if (firstName.length < 3 || firstName.length > 50) {
            alert('First name should be between 3 and 50 characters.');
            return false;
        }

        // Check last name length
        if (lastName.length < 3 || lastName.length > 50) {
            alert('Last name should be between 3 and 50 characters.');
            return false;
        }

        // All validations passed
        return true;
    }
</script>