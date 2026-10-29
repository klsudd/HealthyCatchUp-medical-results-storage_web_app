<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>...:::Home Page:::...</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <?php $activePage = 'home'; include 'navbar.php'; ?>

    <div class="container">
        <h1>Healthy Catch Up</h1>
        <h2>A system where all of your desired biomedical data is stored!</h2>
    </div>

    <br><br>

    <div class = "container">
        <h3>In order to continue, please log in!</h3>
        <p>Check the navbar or use the button below</p>
        <br>
        <a href="p_login.php" class="submit">Log in</a>
    </div>

    <br><br><br>

    <div class = "container">
        <h3>Don't have an account yet? No worries</h3>
        <p>Click the button below to register!</p>
        <br>
        <a href="p_rejestracja.php" class="submit">Register</a>
    </div>
    
</body>