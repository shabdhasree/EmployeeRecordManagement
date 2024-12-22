<?php
session_start(); // Start the session to handle login
$adminUsername = "admin"; // Hardcoded admin username
$adminPassword = "shabdha123"; // Hardcoded admin password

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $adminUsername && $password === $adminPassword) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php"); // Redirect to admin panel
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="admin.php">Admin</a></li>
            <li><a href="training_details.php">Training</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="login-box">
        <h2>Admin Login</h2>
        <form method="post">
            <div class="input-box">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required>
            </div>
            <div class="input-box">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
