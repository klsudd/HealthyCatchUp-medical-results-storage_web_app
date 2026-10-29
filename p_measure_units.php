<?php
session_start();

require_once 'db_config.php';

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT units.unit_id, units.unit_name, exams.measure_id, exams.measure_name
        FROM units
        LEFT JOIN exams ON exams.unit_id = units.unit_id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">
    <title>...:::Available units:::...</title>

</head>

<body>

<div class="container">
        <h1>Available units</h1>
        <h2>Here you can check available units</h2>
        <br><br>
        <p>Please keep in mind that you can also edit and add new units!</p>
        <br><br>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Unit</th>
                        <th>Examination</th>
                        <th>Edit unit</th>
                        <th>Delete unit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                        <td><?php echo htmlspecialchars($row['unit_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['unit_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['measure_name']); ?></td>
                        
                        <td>
                            <a href="p_edit_unit.php?id=<?php echo $row['unit_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                        <td>
                            <a href="p_delete_unit.php?id=<?php echo $row['unit_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this examination?');">Delete</a>
                        </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No units found.</div>
        <?php endif; ?>

    </div>
    <br>
    <a href="p_add_unit.php" class="btn btn-success">Add new unit</a>
    <br>
    <a href ="p_data.php">Back to data</a><br>

</body>
</html>

<?php 
mysqli_close($conn); 
?>