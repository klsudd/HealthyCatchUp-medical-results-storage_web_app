<?php
session_start();

require_once 'db_config.php';

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$error = "";

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unit_name = isset($_POST["unit_name"]) ? trim($_POST["unit_name"]) : "";

    if (empty($unit_name)) {
        $error = "Unit name is required!";
    } else {
        $sql_check_unit = "SELECT unit_id FROM units WHERE unit_name = ? LIMIT 1";
        $stmt_check = mysqli_prepare($conn, $sql_check_unit);
        
        if ($stmt_check) {
            mysqli_stmt_bind_param($stmt_check, "s", $unit_name);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);
            
            if ($result_check && mysqli_num_rows($result_check) > 0) {
                $error = "This unit already exists.";
            } else {
                $sql_insert_unit = "INSERT INTO units (unit_name) VALUES (?)";
                $stmt_insert_unit = mysqli_prepare($conn, $sql_insert_unit);
                
                if ($stmt_insert_unit) {
                    mysqli_stmt_bind_param($stmt_insert_unit, "s", $unit_name);
                    
                    if (mysqli_stmt_execute($stmt_insert_unit)) {
                        $message = "Unit added successfully!";
                        $unit_name = "";
                    } else {
                        $error = "Error creating unit: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt_insert_unit);
                } else {
                    $error = "Prepare failed: " . mysqli_error($conn);
                }
            }
            mysqli_stmt_close($stmt_check);
        }
    }
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">>
    <title>...:::Add unit:::...</title>

</head>

<body>

    <div class="container">
        <h1>Add new unit</h1>
        <h2>Please add a new measurement unit using the form below.</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo esc($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo esc($error); ?></div>
        <?php endif; ?>

        <form action="p_add_unit.php" method="post">
            <div class="form-group">
                <label for="unit_name">Unit name:</label>
                <input type="text" class="form-control" id="unit_name" name="unit_name" value="<?php echo esc($unit_name ?? ""); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Unit</button>
            <a href="p_available_measurements.php" class="btn btn-secondary">Back to Measurements</a>
        </form>

    </div>

    <?php 
    mysqli_close($conn); 
    ?>

</body>

</html>