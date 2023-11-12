<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <a href="dashboard.php" class="nav-link px-2 link-secondary">
                <img src="admin.png" alt="admin" width=220 height=60>
            </a>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link px-2 mt-1 link-body-emphasis">Matchmakers</a>
                </li>
                <li class="nav-item">
                    <a href="view_all_clients.php" class="nav-link mt-1 px-2 link-body-emphasis">Clients</a>
                </li>
                <li class="nav-item">
                    <a href="search.php" class="nav-link mt-1 px-2 link-body-emphasis">Search</a>
                </li>
                <li class="nav-item dropdown me-0 text-end">
                    <a href="#" class="d-block link-body-emphasis mt-2 text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="./../icon.png" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li>
                            <form action="../logout.php" method="POST">
                                <a class="dropdown-item text-dark" href="../logout.php">Log out</a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
