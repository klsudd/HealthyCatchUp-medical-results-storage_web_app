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

    $systolic = "";
    $diastolic = "";
    $time = "";

    $sysErr = "";
    $diasErr = "";

    function chgw($data)
    {
        return htmlspecialchars(trim($data));
    }

    function send_data($conn, $systolic, $diastolic, $time)
    {
        $user_id = $_SESSION["current_user"];
        $measure_id = 1;

        $query = "INSERT INTO examinations 
        (user_id, measure_id, value_a, value_b, created_at) 
        VALUES ('$user_id', '$measure_id', '$systolic', '$diastolic', '$time')";

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

        if (empty($_POST["systolic"])) {
            $sysErr = "Please add a number!";
        } else {
            $systolic = chgw($_POST["systolic"]);
        }

        if (empty($_POST["diastolic"])) {
            $diasErr = "Please add a number!";
        } else {
            $diastolic = chgw($_POST["diastolic"]);
        }
        if (!empty($_POST["date"])) {
            $time = $_POST["date"];
        }

        if (!empty($systolic) && !empty($diastolic)) {
            send_data($conn, $systolic, $diastolic, $time);
        }
    }
?>

<h1>Blood pressure</h1>
<h2>Please add systolic and diastolic blood pressure measurements</h2>

<form action="p_add_data_blood_pressure.php" method="post">

            <label for="systolic">Systolic blood pressure:</label>
            <input type="text" id="systolic" name="systolic" required><br>

            <label for="diastolic">Diastolic blood pressure:</label>
            <input type="text" id=diastolic" name="diastolic" required><br>

            <label for="date">Examination date:</label>
            <input type="date" id="date" name="date" required><br>

            <button type="submit">I'm done</button>
</form>

<br><br>
<a href = "p_data.php">Back to data</a><br>
<br><br>
<a href = "p_check_blood_pressure.php">Check blood pressure</a>

</body>

</html>