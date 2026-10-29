<?php
ob_start();
session_start();
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_email = trim($_POST['email'] ?? '');
    $user_password = $_POST['password'] ?? '';

    if ($user_email === '' || $user_password === '') {
        $errorMessage = 'Please put in your email and password.';
    } else {
        require_once 'db_config.php';

        $dbconn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
        if (!$dbconn) {
            $errorMessage = 'No database connection.';
        } else {
            $sql = "SELECT user_id, user_fullname, user_passwordhash FROM users WHERE user_email = ?";

            $stmt = mysqli_prepare($dbconn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 's', $user_email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                $loginSuccess = false;
                $active_user_id = null;

                $user_id = null;
                $user_fullname = '';
                $hash = '';

                if (mysqli_stmt_num_rows($stmt) === 1) {
                    mysqli_stmt_bind_result($stmt, $user_id, $user_fullname, $hash);
                    mysqli_stmt_fetch($stmt);

                    $active_user_id = $user_id;

                    if (password_verify($user_password, $hash)) {
                        $_SESSION['current_user'] = $user_id;
                        $_SESSION['current_username'] = $user_fullname;
                        $loginSuccess = true;
                    }
                }

                mysqli_stmt_close($stmt);

                $ip = $_SERVER['REMOTE_ADDR'];
                $success = $loginSuccess ? 1 : 0;

                //$userId = mysqli_insert_id($dbconn);

                $attemptSql = "INSERT INTO login_attempts (user_id, user_email, success, ip_address) VALUES (?, ?, ?, ?)";
                $stmt2 = mysqli_prepare($dbconn, $attemptSql);

                if ($stmt2) {
                    mysqli_stmt_bind_param($stmt2, 'isis', $active_user_id, $user_email, $success, $ip);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_close($stmt2);
                }

                if ($loginSuccess) {
                    mysqli_close($dbconn);
                    header('Location: p_home_logged.php');
                    exit;
                }
            } else {
                $errorMessage = 'Error when it comes to database query.';
            }
            mysqli_close($dbconn);
            if ($errorMessage === '') {
                $errorMessage = 'Email or password is incorrect.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>...:::Log in:::...</title>
</head>
<body>

<?php if ($errorMessage !== ''): ?>
    <div style="color: red; margin-bottom: 16px;">
        <?php echo htmlspecialchars($errorMessage); ?>
    </div>
<?php endif; ?>

<p>Go back to the <a href="p_login.php">log in form</a>.</p>

<br><a href="p_logout.php">Log out?</a>
</body>
</html>

