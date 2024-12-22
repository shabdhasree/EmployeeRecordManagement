<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body> <div class="navbar">
        <ul>
            
                <li><a href="index.html">Home</a></li>
                <li><a href="employee.php">User</a></li>
                <li><a href="training_details.php">Training</a></li>
                <li><a href="login.php">Admin</a></li>
            
            
        </ul>
    </div>

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
        ?>

        <!-- Show Leave Records Button -->
        <form method="post" class="gap">
            <button type="submit" name="show_leave_records" class="btn">Show Leave Records</button>
        </form>

        <?php
        // Handle showing leave records
        if (isset($_POST['show_leave_records'])) {
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
        }
        ?>

        <!-- Employee Name Search -->
        <h2>See Details</h2>
        <form method="post">
            <input type="text" name="employee_name" placeholder="Enter Employee Name" required>
            <button type="submit" name="show_details" class="btn">Show Details</button>
        </form>

        <?php
        // Handle the search for employee details
        if (isset($_POST['show_details'])) {
            $employee_name = $_POST['employee_name'];

            // Fetch employee details based on name
            $query = "SELECT * FROM employees WHERE name LIKE '%$employee_name%'";
            $employee_result = $conn->query($query);

            if ($employee_result && $employee_result->num_rows > 0) {
                // Display the employee details in label and text field format
                while ($employee = $employee_result->fetch_assoc()) {
                    echo "<h3>Employee Details</h3>";
                    echo "<label for='employee_name'>Name:</label><input type='text' value='{$employee['name']}' readonly><br>";
                    echo "<label for='employee_email'>Email:</label><input type='text' value='{$employee['email']}' readonly><br>";
                    echo "<label for='employee_phone'>Phone:</label><input type='text' value='{$employee['phone']}' readonly><br>";
                    echo "<label for='employee_department'>Department:</label><input type='text' value='{$employee['department']}' readonly><br>";
                    echo "<label for='employee_position'>Position:</label><input type='text' value='{$employee['position']}' readonly><br>";
                }
            } else {
                echo "<p>No employee found with the name '$employee_name'.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
