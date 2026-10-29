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
    <title>...:::Body temperature:::...</title>

</head>

<body>
    <?php
    
    require_once 'db_config.php';

    $conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $temp_value = "";
    $time = "";

    $tempErr = "";

    function chgw($data)
    {
        return htmlspecialchars(trim($data));
    }

    function send_data($conn, $temp_value, $time)
    {
        $user_id = $_SESSION["current_user"];
        $measure_id = 3;

        $query = "INSERT INTO examinations 
        (user_id, measure_id, value_a, created_at) 
        VALUES ('$user_id', '$measure_id', '$temp_value', '$time')";

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

        if (empty($_POST["temp_value"])) {
            $tempErr = "Please add a number!";
        } else {
            $temp_value = chgw($_POST["temp_value"]);
        }
        if (!empty($_POST["date"])) {
            $time = $_POST["date"];
        }

        if (!empty($temp_value)) {
            send_data($conn, $temp_value, $time);
        }
    }
?>

<h1>Body temperature</h1>
<h2>Please enter your body temperature</h2>

<form action="p_add_data_body_temperature.php" method="post">

            <label for="temp_value">Body temperature (°C):</label>
            <input type="text" id="temp_value" name="temp_value" required><br>

            <label for="date">Examination date:</label>
            <input type="date" id="date" name="date" required><br>

            <button type="submit">I'm done</button>
        </form>

<a href = "p_data.php">Back to data</a><br>
<br><br>
<a href = "p_check_body_temperature.php">Check body temperature</a>

</body>

</html>