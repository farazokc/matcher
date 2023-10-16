<!-- matchmakers/dashboard.php -->
<?php
include(__DIR__ . '/../includes/header.php');
include(__DIR__ . '/navbar.php');
include(__DIR__ . '/../session.php');
?>

<style>
    button a {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Inherit color from parent element (button) */
    }
</style>

<div class="dashboard-container">
    <h1>Welcome to User dashboard!</h1>
</div>

# TODO: ||
<br>
Card showing total clients <br>
Card showing boys list <br>
Card showing girls list <br><br>

<?php 
echo '<pre>'; var_dump($_SESSION); echo '</pre>'
?>

<!-- <button>
    <a class="dropdown-item" href="../logout.php">Log out</a>
</button> -->


<button><a href="add_client.php">Add new client</a></button>
<button><a href="view_clients.php">View all clients(tabular)</a></button>


<?php include(__DIR__ . '/../includes/footer.php'); ?>