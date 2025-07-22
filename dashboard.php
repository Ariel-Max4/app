<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $user_name; ?>!</h2>
        <p>Your role: <?php echo ucfirst(str_replace('_', ' ', $user_role)); ?></p>

        <?php if ($user_role == 'teacher'): ?>
            <h3>Teacher Dashboard</h3>
            <ul>
                <li><a href="attendance.php">Mark Attendance</a></li>
                <li><a href="view_attendance.php">View My Attendance</a></li>
            </ul>
        <?php else: ?>
            <h3>Admin Dashboard</h3>
            <ul>
                <li><a href="view_attendance.php">View All Teacher Attendance</a></li>
                <li><a href="register.php">Register a New User</a></li>
            </ul>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
