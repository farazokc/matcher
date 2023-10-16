<!-- admin/pending.php -->

<?php include(__DIR__.'/../includes/header.php'); ?>

<div class="dashboard-container">
    <h1>Welcome, Admin!</h1>
    Your approval is pending.
</div>

<form action="../logout.php" method="POST">
    <button>Logout</button>
</form>

<?php include(__DIR__.'/../includes/footer.php'); ?>
