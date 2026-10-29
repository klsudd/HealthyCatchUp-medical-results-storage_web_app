<?php
session_start();
if (empty($_SESSION['current_user'])) {
    header('Location: p_login.php');
    exit;
}
$user_fullname = htmlspecialchars($_SESSION['current_username'] ?? '');
?>

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

    <?php $activePage = 'home_logged'; include 'navbar_logged.php'; ?>

    <div class="container">
        <h1>Healthy Catch Up</h1>
        <h2>A system where all of your desired biomedical data is stored!</h2>
        <br><br>
        <h3>Congrats! You have logged in with success</h3>
    </div>

    <div class = "container">
        <h2>Want to add new data?</h2>
        <h3>Please explore the navigation bar!</h3>
    </div>

    <br><br><br>

    <div class = "container">
        <p>If you are done for today, please log out to keep your data safe!</p>
        <p>Check the navbar or use the button below</p>
        <br>
        <a href="p_logout.php" class="submit">Log out</a>

        <br><br><br>
        <p>Also, if you want to change your password, please do using this button.</p>
        <br>
        <a href = "p_change_password.php">Change password</a>
    </div>
    
</body>