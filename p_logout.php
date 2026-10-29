<?php
session_start();
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset = "UTF-8">
    <title>...:::Log out:::...</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="styl.css" rel="stylesheet">
</head>

<body>

<div class="container" style="max-width: 600px; margin-top: 50px;">
    <div class="alert alert-info" style="text-align: center; background-color: #FFB3D9; border-color: #FF99CC; color: #f36dcf;">
        <?php
        session_unset();
        session_destroy();

        if(isset($_SESSION["current_user"])) {
            echo "The user is logged in: ".$_SESSION["current_user"]." as: ".$_SESSION["current_username"];
        }
        else {
            echo "Logged out!";
        }
        ?>
    </div>
    <div style="text-align: center;">
        <a href="p_login.php" class="btn btn-primary">Log in?</a>
    </div>
</div>

</body>
</html>