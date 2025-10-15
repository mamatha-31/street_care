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

$msg = "";

// Process form submission for new feedback.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    // Insert feedback using a prepared statement for security.
    $sql = "INSERT INTO feedback (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $message);
    
    if ($stmt->execute()) {
        $msg = "Feedback submitted successfully!";
    } else {
        $msg = "Error submitting feedback: " . $stmt->error;
    }
    $stmt->close();
}

// Retrieve previous feedback submitted by the resident.
$sql = "SELECT * FROM feedback WHERE user_id = " . $_SESSION['user_id'] . " ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resident Feedback</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Submit Feedback / Report an Issue</h2>
    <?php if ($msg): ?>
        <p><?php echo $msg; ?></p>
    <?php endif; ?>
    <form method="POST">
        <textarea name="message" placeholder="Enter your feedback or report an issue" required></textarea>
        <br>
        <button type="submit">Submit Feedback</button>
    </form>
    <br>
    <h3>Your Previous Feedback</h3>
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
