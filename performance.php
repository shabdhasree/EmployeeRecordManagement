<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance Evaluation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="employee.php">User</a></li>
            <li><a href="login.php">Admin</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="container">
        <h1>Performance Evaluation</h1>

        <form method="post">
            <!-- Employee Name Input -->
            <label for="employee_name">Employee Name:</label>
            <input type="text" name="employee_name" required placeholder="Enter Employee Name">

            <!-- Performance Criteria -->
            <label for="efficiency">Efficiency:</label>
            <input type="number" name="efficiency" min="1" max="10" required placeholder="Rate 1-10">

            <label for="communication">Communication:</label>
            <input type="number" name="communication" min="1" max="10" required placeholder="Rate 1-10">

            <label for="punctuality">Punctuality:</label>
            <input type="number" name="punctuality" min="1" max="10" required placeholder="Rate 1-10">

            <button type="submit" name="submit_performance" class="btn">Submit Evaluation</button>
        </form>

        <?php
        // Handle form submission
        if (isset($_POST['submit_performance'])) {
            $employee_name = $_POST['employee_name'];
            $efficiency = $_POST['efficiency'];
            $communication = $_POST['communication'];
            $punctuality = $_POST['punctuality'];

            // Insert performance data into database
            $sql = "INSERT INTO performance (employee_name, efficiency, communication, punctuality) 
                    VALUES ('$employee_name', '$efficiency', '$communication', '$punctuality')";
            
            if ($conn->query($sql)) {
                echo "<p>Performance evaluation submitted successfully!</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
</body>
</html>
