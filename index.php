<?php

include('includes/connection.php');

$errors = array();
$successMessage = "";

if (isset($_POST["submit"])) {

    $runnerName = $_POST["runner_name"];
    if (empty($runnerName)) {
        $errors[] = "Runner Name is required.";
    }

    // Validate radius
    $radius = $_POST["radius"];
    if (empty($radius)) {
        $errors[] = "Radius is required.";
    }

    // Validate start time
    $startTime = $_POST["start_time"];
    if (empty($startTime)) {
        $errors[] = "Start Time is required.";
    }

    // Validate end time
    $endTime = $_POST["end_time"];
    if (empty($endTime)) {
        $errors[] = "End Time is required.";
    }

    // Validate number of laps
    $numLaps = $_POST["num_laps"];
    if (empty($numLaps)) {
        $errors[] = "Number of Laps is required.";
    }

    // Store in the database
    if (empty($errors)) {
        $sql = "INSERT INTO runners (runner_name, radius, start_time, end_time, num_laps) VALUES ('$runnerName', $radius, '$startTime', '$endTime', $numLaps)";

        if (mysqli_query($conn, $sql)) {
            $successMessage = "Data stored successfully!";
        } else {
            $errors[] = "Error storing data in the database: " . mysqli_error($conn);
        }
    }
}

$sql = "SELECT * FROM runners";
$result = mysqli_query($conn, $sql);

function calculateSpeed($radius, $startTime, $endTime) {
    $distance = 2 * 3.14159 * ($radius / 1000); // Convert radius to kilometers
    $startTimeSeconds = strtotime($startTime);
    $endTimeSeconds = strtotime($endTime);
    $timeDiff = $endTimeSeconds - $startTimeSeconds;
    $timeHours = $timeDiff / 3600;
    $speed = $distance / $timeHours;
    return round($speed, 2);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment</title>

    <!-- bootstrap -->

    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>

<body>

    <main>
        <div class="container px-4 py-5" id="featured-3">
            <h2 class="pb-2 border-bottom">Data input</h2>

            <?php if (!empty($errors) || !empty($successMessage)) : ?>
                <div class="alert <?php echo (!empty($errors) ? 'alert-danger' : 'alert-success'); ?> alert-dismissible fade show" role="alert">
                    <strong><?php echo (!empty($errors) ? 'Error(s):' : 'Success:'); ?></strong>
                    <?php if (!empty($errors)) : ?>
                        </br>
                        <?php foreach ($errors as $error) : ?>
                            <?php echo $error; ?><br>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php echo $successMessage; ?>
                    <?php endif; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">

                <form method="post">

                    <div class="form-group">
                        <label for="runner-name">Runner Name</label>
                        <input type="text" class="form-control" id="runner-name" name="runner_name" placeholder="Enter Runner Name">
                    </div>

                    <div class="form-group">
                        <label for="radius">Radius (m)</label>
                        <input type="number" step="0.01" class="form-control" id="radius" name="radius" placeholder="Enter Radius">
                    </div>

                    <div class="form-group">
                        <label for="start-time">Start Time</label>
                        <input type="time" class="form-control" id="start-time" name="start_time" placeholder="Enter Start Time">
                    </div>

                    <div class="form-group">
                        <label for="end-time">End Time</label>
                        <input type="time" class="form-control" id="end-time" name="end_time" placeholder="Enter End Time">
                    </div>

                    <div class="form-group">
                        <label for="num-laps">Number of Laps</label>
                        <input type="number" class="form-control" id="num-laps" name="num_laps" placeholder="Enter Number of Laps">
                    </div>

                    <br>

                    <div class="text-sm-end">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


            </div>
            <h2 class="pb-2">Report</h2>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Runner Name</th>
                        <th scope="col">Speed (kmph)</th>
                        <th scope="col">Radius</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Number of Laps</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['runner_name'] . "</td>";
                            echo "<td>" . calculateSpeed($row['radius'], $row['start_time'], $row['end_time']) . "</td>";
                            echo "<td>" . $row['radius'] . "</td>";
                            echo "<td>" . $row['start_time'] . "</td>";
                            echo "<td>" . $row['end_time'] . "</td>";
                            // Calculate duration
                            $startTime = strtotime($row['start_time']);
                            $endTime = strtotime($row['end_time']);
                            $duration = round(($endTime - $startTime) / 60);
                            echo "<td>" . $duration . " min</td>";
                            echo "<td>" . $row['num_laps'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'><center>No data available</center></td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </main>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

</body>

</html>

<?php mysqli_close($conn); ?>