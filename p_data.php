<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styl.css">
    <title>...:::Add data:::...</title>
</head>

<body>

    <?php $activePage = 'data'; include 'navbar_logged.php'; ?>

    <div class="container">
        <h1>Healthy Catch Up</h1>

        <br><br>

        <h3>Welcome to the data management page</h3>
        <h3>Here you can add your desired data, analyse it and explore other available options</h3>

        <br><br>

        <h2>Please add your desired biomedical data using the button below</h2>
        <a href="p_add_data.php">Add data</button></a>
    </div>

    <br><br>

    <div class="container">
        <h3>Below, you can find various other options regarding your data</h3>
        <a href = "p_check_data.php">Check your data</a><br>
        <a href = "p_available_measurements.php">Available measurements</a><br>
        <a href = "p_measure_units.php">Available measure units</a><br>

        <br><br>

    </div>

    <div vlass = "container">
        <h3>If you'd like to check out the documentation to this project, take a look at the link below</h3>
        <br>
        <a href = "https://files.catbox.moe/ofpbo9.pdf">Documentation</a><br>
    </div>

</body>