<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="admin.php">Admin</a></li>
            <li><a href="training_details.php">Training</a></li>
            <li><a href="performance.php">Performance</a></li>

            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="container">
        <h1>Admin Panel</h1>
        
        <!-- Add Employee Form -->
        <form method="post">
            <h2>Add Employee</h2>
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <textarea name="address" placeholder="Address"></textarea>
            <input type="text" name="department" placeholder="Department" required>
            <input type="text" name="position" placeholder="Position" required>
            <button type="submit" name="add_employee">Add Employee</button>
        </form>

        <?php
        // Add Employee Logic
        if (isset($_POST['add_employee'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $department = $_POST['department'];
            $position = $_POST['position'];

            $sql = "INSERT INTO employees (name, email, phone, address, department, position) 
                    VALUES ('$name', '$email', '$phone', '$address', '$department', '$position')";
            if ($conn->query($sql)) {
                echo "<p>Employee added successfully!</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
        ?>

        <!-- Buttons for showing and hiding the employee data -->
        <button id="showDataButton" class="btn" onclick="showEmployeeData()">Show Data</button>
        <button id="hideDataButton" class="btn" onclick="hideEmployeeData()" style="display: none;">Hide Data</button>

        <!-- Employee Table (Initially hidden) -->
        <div id="employeeData" style="display: none;">
            <?php
            // Fetching employee data from the database
            $result = $conn->query("SELECT * FROM employees");

            // Debugging SQL error
            if ($result === false) {
                echo "Error in query: " . $conn->error;
            }

            // Check if there are any results
            if ($result->num_rows > 0) {
                echo "<h2>Employee List</h2>";
                echo "<table border='1'>
                        <tr><th>ID</th><th>Name</th><th>Email</th><th>Department</th><th>Position</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['department']}</td>
                            <td>{$row['position']}</td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No employee data available.</p>";
            }
            ?>
        </div>

    </div>

    <script>
        // Function to show employee data
        function showEmployeeData() {
            document.getElementById('employeeData').style.display = 'block';
            document.getElementById('showDataButton').style.display = 'none'; // Hide "Show Data" button
            document.getElementById('hideDataButton').style.display = 'inline'; // Show "Hide Data" button
        }

        // Function to hide employee data
        function hideEmployeeData() {
            document.getElementById('employeeData').style.display = 'none';
            document.getElementById('showDataButton').style.display = 'inline'; // Show "Show Data" button
            document.getElementById('hideDataButton').style.display = 'none'; // Hide "Hide Data" button
        }
    </script>
    </div>
</body>
</html>
