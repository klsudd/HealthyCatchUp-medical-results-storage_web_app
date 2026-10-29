<?php
session_start();

if (!isset($_SESSION['current_user']))
    {
        die("You are not logged in. Please log in to change your password.");
    }
if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password)
            {
                die("New password and confirm password do not match.");
            }

        if ($current_password === $new_password)
            {
                die("New password cannot be the same as the current password.");
            }
        
        $user_id = $_SESSION['current_user'];
        require_once 'db_config.php';
        $dbconn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
        $sql = "SELECT user_passwordhash FROM users WHERE user_id = ?";

        $stmt = mysqli_prepare($dbconn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $current_hash);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($current_hash === null) {
            die("Unable to verify current password. Please log in again.");
        }

        if (password_verify($current_password, $current_hash)) {
        
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
        
            $updateSql = "UPDATE users SET user_passwordhash = ? WHERE user_id = ?";
            $updateStmt = mysqli_prepare($dbconn, $updateSql);
            mysqli_stmt_bind_param($updateStmt, 'si', $new_hash, $user_id);
        
            if (mysqli_stmt_execute($updateStmt)) {
                echo "Password successfully updated!";
            } else {
                echo "Error updating password.";
            }
            mysqli_stmt_close($updateStmt);

        } else {
            echo "The current password you entered is incorrect.";
        }

        mysqli_close($dbconn);
    }
?>


<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl.css">
    <title>...:::Login:::...</title>

</head>

<body>

    <div class="container">
        <h1>Heard you want to change your password?</h1>
        <h2>If it is true, please use this form below in order to do so.</h2>

        <form action="p_change_password.php" method="post">

            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Change Password</button>
        </form>
    </div>

</body>
</html>