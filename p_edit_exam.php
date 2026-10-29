<?php
session_start();

require_once 'db_config.php';

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$error = "";
$exam_name = "";
$exam_unit = "";
$measure_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($measure_id <= 0) {
    die("Error: Invalid exam ID.");
}

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$sql_fetch = "SELECT exams.measure_name, units.unit_name FROM exams 
              LEFT JOIN units ON exams.unit_id = units.unit_id 
              WHERE exams.measure_id = ?";

$stmt_fetch = mysqli_prepare($conn, $sql_fetch);

if ($stmt_fetch) {
    mysqli_stmt_bind_param($stmt_fetch, "i", $measure_id);
    mysqli_stmt_execute($stmt_fetch);
    $result_fetch = mysqli_stmt_get_result($stmt_fetch);
    
    if ($result_fetch && mysqli_num_rows($result_fetch) > 0) {
        $row = mysqli_fetch_assoc($result_fetch);
        $exam_name = $row['measure_name'];
        $exam_unit = $row['unit_name'];

    } else {
        die("Error: Exam not found.");
    }
    mysqli_stmt_close($stmt_fetch);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_name = isset($_POST["exam_name"]) ? trim($_POST["exam_name"]) : "";
    $exam_unit = isset($_POST["exam_unit"]) ? trim($_POST["exam_unit"]) : "";

    if (empty($exam_name)) {
        $error = "Examination name is required!";
    } elseif (empty($exam_unit)) {
        $error = "Examination unit is required!";
    } else {
        $sql_check_unit = "SELECT unit_id FROM units WHERE unit_name = ? LIMIT 1";
        $stmt_check = mysqli_prepare($conn, $sql_check_unit);
        
        if ($stmt_check) {
            mysqli_stmt_bind_param($stmt_check, "s", $exam_unit);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);
            
            if ($result_check && mysqli_num_rows($result_check) > 0) {
                $row = mysqli_fetch_assoc($result_check);
                $unit_id = $row['unit_id'];
            } else {
                $sql_insert_unit = "INSERT INTO units (unit_name) VALUES (?)";
                $stmt_insert_unit = mysqli_prepare($conn, $sql_insert_unit);
                
                if ($stmt_insert_unit) {
                    mysqli_stmt_bind_param($stmt_insert_unit, "s", $exam_unit);
                    
                    if (mysqli_stmt_execute($stmt_insert_unit)) {
                        $unit_id = mysqli_insert_id($conn);
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
        if (empty($error) && isset($unit_id)) {
            $sql_update = "UPDATE exams SET measure_name = ?, unit_id = ? WHERE measure_id = ?";
            $stmt = mysqli_prepare($conn, $sql_update);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sii", $exam_name, $unit_id, $measure_id);
                
                if (mysqli_stmt_execute($stmt)) {
                    $message = "Examination updated successfully!";
                } else {
                    $error = "Error updating examination: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
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
    <title>...:::Edit Exam:::...</title>

</head>

<body>

    <div class="container">
        <h1>Edit Examination</h1>
        <h2>Edit exam details below.</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo esc($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo esc($error); ?></div>
        <?php endif; ?>

        <form action="p_edit_exam.php?id=<?php echo $measure_id; ?>" method="post">

            <div class="form-group">
                <label for="exam_name">Exam Name:</label>
                <input type="text" class="form-control" id="exam_name" name="exam_name" value="<?php echo esc($exam_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="exam_unit">Exam Unit:</label>
                <input type="text" class="form-control" id="exam_unit" name="exam_unit" value="<?php echo esc($exam_unit); ?>" required>  
            </div>

            <button type="submit" class="btn btn-primary">Update Examination</button>
            <a href="p_available_measurements.php" class="btn btn-secondary">Back to Measurements</a>

        </form>

    </div>

    <?php 
    mysqli_close($conn); 
    ?>

</body>

</html>