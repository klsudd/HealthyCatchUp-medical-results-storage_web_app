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

$unit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($unit_id <= 0) {
    die("Error: Invalid unit ID.");
}

$sql_fetch = "SELECT unit_name FROM units WHERE unit_id = ?";
$stmt_fetch = mysqli_prepare($conn, $sql_fetch);

if ($stmt_fetch) {
    mysqli_stmt_bind_param($stmt_fetch, 'i', $unit_id);
    mysqli_stmt_execute($stmt_fetch);
    $res = mysqli_stmt_get_result($stmt_fetch);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $unit_name = $row['unit_name'];
    } else {
        die("Error: Unit not found.");
    }
    mysqli_stmt_close($stmt_fetch);

} else {
    die("Prepare failed: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $confirm = isset($_POST['confirm']) ? intval($_POST['confirm']) : 0;
    if ($confirm === 1) {
        $sql_del = "DELETE FROM units WHERE unit_id = ?";
        $stmt_del = mysqli_prepare($conn, $sql_del);
        if ($stmt_del) {
            mysqli_stmt_bind_param($stmt_del, 'i', $unit_id);
            if (mysqli_stmt_execute($stmt_del)) {
                header('Location: p_available_measurements.php');
                mysqli_stmt_close($stmt_del);
                mysqli_close($conn);
                exit;
            } else {
                $error = "Error deleting unit: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt_del);
        } else {
            $error = "Prepare failed: " . mysqli_error($conn);
        }
    } else {
        $error = "Deletion not confirmed.";
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
    <title>...:::Delete Unit:::...</title>

</head>

<body>

    <div class="container">
        <h1>Delete Unit</h1>
        <h2>Are you sure you want to delete this unit?</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo esc($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo esc($error); ?></div>
        <?php endif; ?>

        <div class="well">
            <p><strong>Unit:</strong> <?php echo esc($unit_name); ?></p>
        </div>

        <form action="p_delete_unit.php?id=<?php echo $unit_id; ?>" method="post">
            <input type="hidden" name="confirm" value="1">
            <button type="submit" class="btn btn-danger">Delete Unit</button>
            <a href="p_available_measurements.php" class="btn btn-default">Cancel</a>
        </form>

    </div>

    <?php 
    mysqli_close($conn); 
    ?>

</body>

</html>