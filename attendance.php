<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'teacher') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$today = date("Y-m-d");
$message = '';

// Check if attendance for today already exists
$sql = "SELECT id, arrival_time, departure_time FROM attendance WHERE user_id = ? AND date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();
$attendance = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['arrival'])) {
        if (!$attendance) {
            $arrival_time = date("Y-m-d H:i:s");
            $sql = "INSERT INTO attendance (user_id, date, arrival_time) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $user_id, $today, $arrival_time);
            if ($stmt->execute()) {
                $message = "Arrival time marked successfully.";
                // Refresh the page to show updated status
                header("Location: attendance.php");
                exit();
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } elseif (isset($_POST['departure'])) {
        if ($attendance && !$attendance['departure_time']) {
            $departure_time = date("Y-m-d H:i:s");
            $sql = "UPDATE attendance SET departure_time = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $departure_time, $attendance['id']);
            if ($stmt->execute()) {
                $message = "Departure time marked successfully.";
                // Refresh the page to show updated status
                header("Location: attendance.php");
                exit();
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Mark Attendance for <?php echo $today; ?></h2>
        <?php if (!empty($message)) { echo "<p class='message'>".$message."</p>"; } ?>

        <form method="post" action="">
            <?php if (!$attendance): ?>
                <button type="submit" name="arrival">Mark Arrival</button>
            <?php elseif (!$attendance['departure_time']): ?>
                <p>Arrival Time: <?php echo $attendance['arrival_time']; ?></p>
                <button type="submit" name="departure">Mark Departure</button>
            <?php else: ?>
                <p>Arrival Time: <?php echo $attendance['arrival_time']; ?></p>
                <p>Departure Time: <?php echo $attendance['departure_time']; ?></p>
                <p>You have already marked your attendance for today.</p>
            <?php endif; ?>
        </form>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
