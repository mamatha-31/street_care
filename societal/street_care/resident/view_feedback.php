<?php
include '../includes/db.php';

// Start session only if not already active.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure only residents can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    header("Location: ../login.php");
    exit();
}

// Retrieve feedback entries for the logged-in resident.
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM feedback WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View My Feedback</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Your Feedback</h2>
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($row['message']); ?>
                    <small>(<?php echo $row['created_at']; ?>)</small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You have not submitted any feedback yet.</p>
    <?php endif; ?>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
