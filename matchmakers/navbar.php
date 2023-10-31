<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li>
                    <a href="view_all.php" class="nav-link px-2 link-secondary">
                        <img src="matchmaker.png" alt="matchmaker" width="58" height="50">
                    </a>
                </li>
                <li>
                    <a href="add_client.php" class="nav-link px-2 link-body-emphasis" style="margin-top:11px;">Add New
                        Client
                    </a>
                </li>
                <li>
                    <a href="view_all.php" class="nav-link px-2 link-body-emphasis" style="margin-top:11px;">
                        View Your Clients
                    </a>
                </li>
                <!-- <li><a href="search.php" class="nav-link px-2 link-body-emphasis">Search</a></li> -->
            </ul>
            <div class="dropdown text-end">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./../icon.png" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small">
                    <li>
                        <form action="../logout.php" method="POST">
                            <a class="dropdown-item" href="../logout.php">Log out</a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>