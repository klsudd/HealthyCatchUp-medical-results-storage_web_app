<?php
session_start();

$errors = [];
$successMessage = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $errors[] = 'Please enter your email address.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';

    } else {
        require_once 'db_config.php';

        $conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

        if (!$conn) {
            $errors[] = 'Database connection failed: ' . mysqli_connect_error();
        } else {
            $stmt = mysqli_prepare($conn, 'SELECT user_id FROM users WHERE user_email = ?');
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 's', $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) === 1) {
                    mysqli_stmt_bind_result($stmt, $user_id);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);

                    $_SESSION['reset_user_id'] = $user_id;
                    $_SESSION['reset_email'] = $email;
                    $_SESSION['reset_code'] = rand(100000, 999999);

                    $to = $email;
                    $subject = 'Healthy Catch Up - Password Reset Code';
                    $message = "Your password reset code is: " . $_SESSION['reset_code'] . "\n";
                    $message .= "If if was not you who have requested this email, you can freely ignore this message. Thanks!";

                    if (mail($to, $subject, $message)) {
                        $successMessage = 'A reset code has been sent to your email address. Check your inbox.';
                    } else {
                        $errors[] = 'Unable to send email. Please try again later or contact support.';
                    }
                } else {
                    $errors[] = 'No account found with that email address.';
                    mysqli_stmt_close($stmt);
                }
            } else {
                $errors[] = 'Database query failed: ' . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>...:::Forgot password:::...</title>
</head>

<body>

    <div class="container">
        <h1>Seems like you forgot your password?</h1>
        <h2>Don't worry! Please type in your email address (linked to your account).</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($successMessage !== ''): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <form action="p_forgot_password.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <br><br>
            <a href = "p_verification_code.php">Already have a reset code?</a>
        </form>
    </div>

</body>
</html>