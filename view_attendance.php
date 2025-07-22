<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

$sql = "";
if ($user_role == 'teacher') {
    $sql = "SELECT u.name, a.date, a.arrival_time, a.departure_time
            FROM attendance a
            JOIN users u ON a.user_id = u.id
            WHERE a.user_id = ?
            ORDER BY a.date DESC";
} else {
    $sql = "SELECT u.name, a.date, a.arrival_time, a.departure_time
            FROM attendance a
            JOIN users u ON a.user_id = u.id
            ORDER BY a.date DESC, u.name ASC";
}

$stmt = $conn->prepare($sql);
if ($user_role == 'teacher') {
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Attendance</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Attendance Records</h2>

        <?php if ($user_role != 'teacher'): ?>
        <!-- Add filter options for admins here in the future -->
        <?php endif; ?>

        <table>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Arrival Time</th>
                <th>Departure Time</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['arrival_time']; ?></td>
                <td><?php echo $row['departure_time']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
