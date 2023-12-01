<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Your Logo/Brand</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="news.php">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="game.php">Game</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="stat.php">Stats</a>
                </li>
                <?php if ($_SESSION['isAdmin']) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
