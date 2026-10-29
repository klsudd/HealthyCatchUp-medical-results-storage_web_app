<?php
session_start();

require_once 'db_config.php';

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$error = "";
$unit_name = "";
$unit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($unit_id <= 0) {
    die("Error: Invalid unit ID.");
}

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$sql_fetch = "SELECT unit_name FROM units WHERE unit_id = ?";
$stmt_fetch = mysqli_prepare($conn, $sql_fetch);

if ($stmt_fetch) {
    mysqli_stmt_bind_param($stmt_fetch, "i", $unit_id);
    mysqli_stmt_execute($stmt_fetch);
    $result_fetch = mysqli_stmt_get_result($stmt_fetch);
    
    if ($result_fetch && mysqli_num_rows($result_fetch) > 0) {
        $row = mysqli_fetch_assoc($result_fetch);
        $unit_name = $row['unit_name'];
    } else {
        die("Error: Unit not found.");
    }
    mysqli_stmt_close($stmt_fetch);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unit_name = isset($_POST["unit_name"]) ? trim($_POST["unit_name"]) : "";

    if (empty($unit_name)) {
        $error = "Unit name is required!";
    } else {
        $sql_check_unit = "SELECT unit_id FROM units WHERE unit_name = ? AND unit_id != ? LIMIT 1";
        $stmt_check = mysqli_prepare($conn, $sql_check_unit);

        if ($stmt_check) {
            mysqli_stmt_bind_param($stmt_check, "si", $unit_name, $unit_id);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);

            if ($result_check && mysqli_num_rows($result_check) > 0) {
                $error = "This unit name already exists.";
            }
            mysqli_stmt_close($stmt_check);
        }

        if (empty($error)) {
            $sql_update = "UPDATE units SET unit_name = ? WHERE unit_id = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update);

            if ($stmt_update) {
                mysqli_stmt_bind_param($stmt_update, "si", $unit_name, $unit_id);
                
                if (mysqli_stmt_execute($stmt_update)) {
                    $message = "Unit updated successfully!";
                } else {
                    $error = "Error updating unit: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt_update);
            } else {
                $error = "Prepare failed: " . mysqli_error($conn);
            }
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
    <link rel="stylesheet" href="styl.css">
    <title>...:::Edit Unit:::...</title>

</head>

<body>

    <div class="container">
        <h1>Edit Unit</h1>
        <h2>Update the unit name below.</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo esc($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo esc($error); ?></div>
        <?php endif; ?>

        <form action="p_edit_unit.php?id=<?php echo $unit_id; ?>" method="post">
            <div class="form-group">
                <label for="unit_name">Unit Name:</label>
                <input type="text" class="form-control" id="unit_name" name="unit_name" value="<?php echo esc($unit_name); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Unit</button>
            <a href="p_measure_units.php" class="btn btn-secondary">Back to Units</a>
        </form>

    </div>

    <?php 
    mysqli_close($conn); 
    ?>

</body>

</html>