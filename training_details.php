<?php
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_name = $_POST['employee_name'];

    // Fetch employee details from the database
    $query = "SELECT *, 
              CASE 
                  WHEN RAND() < 0.5 THEN 'Completed' 
                  ELSE 'Pending' 
              END as status 
              FROM employees 
              WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $employee_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $employee_details = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
        <ul>
            
                <li><a href="index.html">Home</a></li>
                <li><a href="employee.php">User</a></li>
                <li><a href="training_details.php">Training</a></li>
                <li><a href="login.php">Admin</a></li>
                <li><a href="logout.php">Logout</a></li>
            
            
        </ul>
    </div>
    <div class="container">
        <h1>Training Detail</h1>
        
        <!-- Form to get employee training status -->
        <form method="post">
            <label for="employee_name">Enter Employee Name:</label>
            <input type="text" id="employee_name" name="employee_name" placeholder="Employee Name" required>
            <button type="submit" class="btn">Show Status</button>
        </form>

        <?php if (!empty($employee_details)) { ?>
            <h2>Employee Details</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($employee_details['name']); ?></td>
                    <td><?php echo htmlspecialchars($employee_details['email']); ?></td>
                    <td><?php echo htmlspecialchars($employee_details['phone']); ?></td>
                    <td><?php echo htmlspecialchars($employee_details['department']); ?></td>
                    <td><?php echo htmlspecialchars($employee_details['position']); ?></td>
                    <td><?php echo htmlspecialchars($employee_details['status']); ?></td>
                </tr>
            </table>
        <?php } elseif (isset($_POST['employee_name'])) { ?>
            <p style="color: red;">No employee found with the name "<?php echo htmlspecialchars($_POST['employee_name']); ?>"</p>
        <?php } ?>
    </div>
</body>
</html>
