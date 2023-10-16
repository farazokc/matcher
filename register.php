<!-- register_matchmaker.php -->

<?php include('includes/header.php'); ?>

<style>
    <?php include('index.css'); ?>
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
</style>

<div class="d-flex align-items-center py-4 bg-body-tertiary h-100">
    <main class="form-signin w-100 m-auto">
        <form action="register_process.php" method="POST">
            <h1 class="h3 mb-3 fw-normal">Register</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" required>
                <label for="first_name">First name</label>
            </div>

            <div class="form-floating">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" required>
                <label for="last_name">Last name</label>
            </div>

            <div class="form-floating">
                <input type="number" class="form-control" id="phone" name="phone" maxlength="11" minlength="11" placeholder="" required>
                <label for="phone">Phone</label>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                <label for="email">Email address</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="" required>
                <label for="password">Password</label>
            </div>

            <div class="form-floating">
                User Type:
                <div>
                    <input type="radio" id="user" name="type" value="user" checked/>
                    <label for="user">User</label>
                </div>
                <div>
                    <input type="radio" id="admin" name="type" value="admin" />
                    <label for="admin">Admin (Requires manual approval)</label>
                </div>
            </div>

            <div class="redirect-link">
                <p>Already a member? <a href="index.php">Login!</a></p>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; MKAGI</p>
        </form>
    </main>
</div>

<?php include('includes/footer.php'); ?>