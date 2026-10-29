<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="p_home_logged.php">Healthy Catch Up Logged</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="<?php echo ($activePage ?? '') === 'home_logged' ? 'active' : ''; ?>">
                <a href="p_home_logged.php">Home</a>
            </li>

            <li class="<?php echo ($activePage ?? '') === 'data' ? 'active' : ''; ?>">
                <a href="p_data.php">Data</a>
            </li>
            <li class="<?php echo ($activePage ?? '') === 'logout' ? 'active' : ''; ?>">
                <a href="p_logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
