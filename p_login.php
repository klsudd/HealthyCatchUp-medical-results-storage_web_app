<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">
    <title>...:::Login:::...</title>

</head>

<body>

    <?php $activePage = 'login'; include 'navbar.php'; ?>

    <div class="container">
        <h1>Login</h1>
        <h2>Welcome back! Please log in using the form below</h2>

        <br><br>

        <form action="p_logistration.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Send">
            <br><br>

            <a href = "p_forgot_password.php">Forgot password?</a>

        </form>
    </div>

    <br><br>

    <div class = "container">
        <p>Don't have an account yet? No worries!</p>
        <p>Register using the button below</p>
        <a href="p_register.php">Register</a>
    </div>

</body>