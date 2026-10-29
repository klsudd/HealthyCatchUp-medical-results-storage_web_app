<?php

session_start();

    if (!isset($_SESSION['current_user']) || empty($_SESSION['current_user'])) {
        die("Error: You must be logged in to add an examination.");
    }

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">>
    <title>...:::Blood pressure:::...</title>

</head>

<body>
    <?php
    
    require_once 'db_config.php';

    $conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $gluc_value = "";
    $time = "";

    $glucErr = "";

    function chgw($data)
    {
        return htmlspecialchars(trim($data));
    }

    function send_data($conn, $gluc_value, $time)
    {
        $user_id = $_SESSION["current_user"];
        $measure_id = 2;

        $query = "INSERT INTO examinations 
        (user_id, measure_id, value_a, created_at) 
        VALUES ('$user_id', '$measure_id', '$gluc_value', '$time')";

        try {
            if (mysqli_query($conn, $query)) {
                echo "Dopisano!";
            } else {
                echo "Błąd: " . $query . "<br>" . mysqli_error($conn);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["gluc_value"])) {
            $glucErr = "Please add a number!";
        } else {
            $gluc_value = chgw($_POST["gluc_value"]);
        }
        if (!empty($_POST["date"])) {
            $time = $_POST["date"];
        }

        if (!empty($gluc_value)) {
            send_data($conn, $gluc_value, $time);
        }
    }
?>

<h1>Blood glucose</h1>
<h2>Enter the blood glusose parameter</h2>

<form action="p_add_data_glucose.php" method="post">

            <label for="gluc_value">Blood glucose:</label>
            <input type="text" id="gluc_value" name="gluc_value" required><br>

            <label for="date">Examination date:</label>
            <input type="date" id="date" name="date" required><br>

            <button type="submit">I'm done</button>
        </form>

<a href = "p_data.php">Back to data</a><br>
<br><br>
<a href = "p_check_data_glucose.php">Check blood glucose</a>

</body>

</html>