<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="p_home_page.php">Healthy Catch Up</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="<?php echo ($activePage ?? '') === 'home' ? 'active' : ''; ?>">
                <a href="p_home_page.php">Home</a>
            </li>

            <li class="<?php echo ($activePage ?? '') === 'about' ? 'active' : ''; ?>">
                <a href="p_about.php">About</a>
            </li>
            <li class="<?php echo ($activePage ?? '') === 'contact' ? 'active' : ''; ?>">
                <a href="p_contact.php">Contact</a>
            </li>
            <li class="<?php echo ($activePage ?? '') === 'login' ? 'active' : ''; ?>">
                <a href="p_login.php">Login</a>
            </li>
        </ul>
    </div>
</nav>
