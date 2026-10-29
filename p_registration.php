<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: p_register.php');
    exit;
}

$user_name = trim($_POST['name'] ?? '');
$user_email = trim($_POST['email'] ?? '');
$user_password = $_POST['password'] ?? '';

if ($user_name === '' || $user_email === '' || $user_password === '') {
    echo "All fields are required. <a href=\"p_register.php\">Go back</a>";
    exit;
}

if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email address. <a href=\"p_register.php\">Go back</a>";
    exit;
}

require_once 'db_config.php';

$dbconn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
if (!$dbconn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$name = mysqli_real_escape_string($dbconn, $user_name);
$email = mysqli_real_escape_string($dbconn, $user_email);
$passwordhash = password_hash($user_password, PASSWORD_DEFAULT);

$insertSql = "INSERT INTO users (user_fullname, user_email, user_passwordhash) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($dbconn, $insertSql);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($dbconn));
}
mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $passwordhash);
if (!mysqli_stmt_execute($stmt)) {
    echo "Registration failed: " . mysqli_stmt_error($stmt) . " <a href=\"p_register.php\">Go back</a>";
    mysqli_stmt_close($stmt);
    mysqli_close($dbconn);
    exit;
}
mysqli_stmt_close($stmt);

$ip = $_SERVER['REMOTE_ADDR'];
$success = 1;

$attemptSql = "INSERT INTO login_attempts (user_email, success, ip_address) VALUES (?, ?, ?)";
$stmt2 = mysqli_prepare($dbconn, $attemptSql);
if ($stmt2) {
    mysqli_stmt_bind_param($stmt2, 'sis', $email, $success, $ip);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
}

mysqli_close($dbconn);

echo "Your account was created successfully!<br>";
echo "You can now log in to your account using the button below.<br>";
echo "<a href=\"p_login.php\">Log in</a>";

?>