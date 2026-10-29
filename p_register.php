<!DOCTYPE html>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>...:::Register:::...</title>

</head>

<body>

    <div class = "container">
        <h1>Registration</h1>
        <h2>Fill up your register info in the form down below!</h2>
    </div>

    <form method = "POST" action = "p_registration.php">
    <input type = "text" name = "name" placeholder = "Username"><br>
    <input type = "email" name = "email" placeholder = "E-mail"><br>
    <input type = "password" name = "password" placeholder = "Password"><br>
    
    <input type = "submit" name = "submit" value = "Send">

    </form>

</body>

</html>