<?php
include('includes' . DIRECTORY_SEPARATOR . 'header.php');
?>

<style>
    <?php include('index.css'); ?>
    input[type="radio"] {
        vertical-align: middle;
    }
</style>

<body class="d-flex align-items-center bg-body-tertiary h-100">
    <main class="form-signin w-100 m-auto">
        <form onsubmit="login(event)" method="POST">
     
        <a href="index.php" class="nav-link px-2 link-secondary">
        <img src="admin\admin.png" alt="admin" width=220 height=60>
</a>

        <h1 class="h3 mb-3 fw-normal"></h1>
            <div class="alert alert-danger alert-dismissible d-none fade show" id="wrong-password-alert" role="alert">
                <strong>Incorrect email or password</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control" name="email" id="email" placeholder="" required>
                <label for="email">Email address</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="" required>
                <label for="password">Password</label>
            </div>

            <div class="form-floating">
                User Type:
                <div>
                    <input type="radio" id="user" name="type" value="user" checked />
                    <label for="user">User</label>
                </div>
                <div>
                    <input type="radio" id="admin" name="type" value="admin" />
                    <label for="admin">Admin</label>
                </div>
            </div>
            <hr>
            <div class="redirect-link">
                <p>Not a member? <a href="register.php">Register here!</a></p>
            </div>
            <div class="forgot-password">
                <p><a href="" onclick="pwdAlert()">Forgot your email/password?</a></p>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        </form>
    </main>
    
</body>

<?php include('includes' . DIRECTORY_SEPARATOR . 'footer.php'); ?>
<script>
    function pwdAlert(){
        alert("Please contact the admin to reset your password.");
    }

    async function login(event) {
        event.preventDefault();

        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let type = document.querySelector('input[name="type"]:checked').value;

        await loginUser(email, password, type);
    }

    async function loginUser(email, password, type) {
        try {
            const response = await fetch('login_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `email=${email}&password=${password}&type=${type}`
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            // console.log(data);

            if (!data.success && data.message == "pwd") {
                document.getElementById("wrong-password-alert").classList.remove("d-none");
            } else if (data.success && data.message == "user") {
                <?php 
                $path_user = './matchmakers/view_all.php';
                ?>
                window.location.href = '<?php echo $path_user ?>' ;
            } else if (data.success && data.message == "pending") {
                alert("Your account is still pending approval. Please wait for the admin to approve your account.");
            } else if (data.success && data.message == "admin") {
                <?php 
                $path_admin = './admin/dashboard.php';
                ?>
                window.location.href = '<?php echo $path_admin ?>' ;
            }
        } catch (e) {
            console.log(e);
        }
    }
</script>