<?php
session_start();

if (!isset($_SESSION['current_user']) || empty($_SESSION['current_user'])) {
    die("Error: You must be logged in to view measurements.");
}

require_once 'db_config.php';

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = intval($_SESSION['current_user']);

$sql = "SELECT examination_id, value_a, value_b, created_at FROM examinations WHERE user_id = ? AND measure_id = 1 ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">
    <title>...:::Check data:::...</title>

</head>

<body>
    <div class="container">
        <h1>Blood pressure measurements</h1>
        <h2>Here you can check your added blood pressure measurements</h2>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Systolic</th>
                        <th>Diastolic</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo esc($row['examination_id']); ?></td>
                            <td><?php echo esc($row['value_a']); ?></td>
                            <td><?php echo esc($row['value_b']); ?></td>
                            <td><?php echo esc($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No blood pressure measurements found.</div>
        <?php endif; ?>

    </div>

    <br><br> 
    <a href = "p_data.php">Back to data</a><br>

    <?php
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    ?>

</body>

</html>