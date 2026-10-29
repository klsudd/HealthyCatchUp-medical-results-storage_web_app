<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verification = $_POST['verification'];

    if ($verification == $_SESSION['verification_code']) {
        echo "<script>alert('Verification successful!');</script>";
        // redirect to the login page
        header("Location: p_login.php");
        exit();
    } else {
        echo "<script>alert('Invalid verification code. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl.css">

    <title>...:::Verification code:::...</title>
</head>

<body>
    <div class = "container">
        <h1>Congrats on your verification code!</h1>
        <h2>Please enter the code in the tab below:</h2>
        <br><br>
        <h3>Verification code:</h3>

        <form action="p_verification_code.php" method="post">
            <div class="form-group">
                <label for="verification">Verification code:</label>
                <input type="verification" class="form-control" id="verification" placeholder="Enter a verification code" name="verification">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
    </div>


</body>

</html>