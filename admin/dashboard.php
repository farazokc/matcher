<!-- admin/dashboard.php -->

<?php include(__DIR__.'/../includes/header.php'); ?>

<div class="dashboard-container">
    <h1>Welcome, Admin!</h1>
    <div class="admin-options">
        <a href="view_matchmakers.php">View Matchmakers</a>
    </div>
</div>

<form action="../logout.php" method="POST">
    <button>Logout</button>
</form>

<?php include(__DIR__.'/../includes/footer.php'); ?>
