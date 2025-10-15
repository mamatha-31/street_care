<?php
include '../includes/db.php';  // Include your database connection file
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'worker') {
    header("Location: ../login.php");
    exit();
}

$worker_id = $_SESSION['user_id'];

// Retrieve tasks assigned to the logged-in worker.
$sql = "SELECT * FROM tasks WHERE assigned_to = $worker_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Worker Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Welcome Worker</h2>
    <h3>Your Tasks</h3>
    <?php if ($result->num_rows > 0): ?>
        <ul>
        <?php while($task = $result->fetch_assoc()): ?>
            <li>
                <strong><?php echo $task['title']; ?></strong> - <?php echo ucfirst($task['status']); ?>
                <br>
                <a href="update_task.php?id=<?php echo $task['id']; ?>">Update Task</a>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No tasks assigned.</p>
    <?php endif; ?>
    <br>
    <a href="../logout.php">Logout</a>
</body>
</html>
