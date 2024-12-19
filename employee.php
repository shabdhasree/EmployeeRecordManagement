<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Employee Panel</h1>
        
        <!-- Apply for Leave Form -->
        <form method="post">
            <h2>Apply for Leave</h2>
            <input type="number" name="employee_id" placeholder="Employee ID" required>
            <select name="leave_type" required>
                <option value="">Select Leave Type</option>
                <option value="Annual">Annual</option>
                <option value="Medical">Medical</option>
                <option value="Casual">Casual</option>
            </select>
            <input type="date" name="start_date" required>
            <input type="date" name="end_date" required>
            <button type="submit" name="apply_leave" class="btn">Apply Leave</button>
        </form>

        <?php
        // Handle leave application submission
        if (isset($_POST['apply_leave'])) {
            $employee_id = $_POST['employee_id'];
            $leave_type = $_POST['leave_type'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $sql = "INSERT INTO leaves (employee_id, leave_type, start_date, end_date, status) 
                    VALUES ('$employee_id', '$leave_type', '$start_date', '$end_date', 'Pending')";
            if ($conn->query($sql)) {
                echo "<p>Leave applied successfully!</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        // Fetch leave records from the database
        $result = $conn->query("SELECT * FROM leaves");
        
        // Display leave records in a table
        echo "<h2>Leave Records</h2>";
        echo "<div id='leaveData'>
                <table>
                    <tr><th>ID</th><th>Employee ID</th><th>Leave Type</th><th>Status</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['employee_id']}</td>
                    <td>{$row['leave_type']}</td>
                    <td>{$row['status']}</td>
                </tr>";
        }
        echo "</table>
              </div>";
        ?>
    </div>
</body>
</html>
