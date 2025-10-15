<?php
include '../includes/db.php';

// Start session only if not already active.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure only workers can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'worker') {
    header("Location: ../login.php");
    exit();
}

// Retrieve the task based on the passed ID.
$task_id = $_GET['id'];
$sql = "SELECT * FROM tasks WHERE id = $task_id AND assigned_to = " . $_SESSION['user_id'];
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Task not found or you do not have permission to update this task.";
    exit();
}

$task = $result->fetch_assoc();

// Define upload directory and create it if it doesn't exist.
$uploadDir = "../uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    
    // Retain current photo paths if no new files are uploaded.
    $before_photo = $task['before_photo'];
    $after_photo  = $task['after_photo'];

    // Upload Before Photo
    if (isset($_FILES['before_photo']) && $_FILES['before_photo']['error'] == 0) {
        $before_photo_name = basename($_FILES['before_photo']['name']);
        $targetBefore = $uploadDir . time() . "_before_" . $before_photo_name;
        if (move_uploaded_file($_FILES['before_photo']['tmp_name'], $targetBefore)) {
            $before_photo = $targetBefore;
        } else {
            echo "Error uploading before photo.";
        }
    }
    
    // Upload After Photo
    if (isset($_FILES['after_photo']) && $_FILES['after_photo']['error'] == 0) {
        $after_photo_name = basename($_FILES['after_photo']['name']);
        $targetAfter = $uploadDir . time() . "_after_" . $after_photo_name;
        if (move_uploaded_file($_FILES['after_photo']['tmp_name'], $targetAfter)) {
            $after_photo = $targetAfter;
        } else {
            echo "Error uploading after photo.";
        }
    }

    // Update the task record with new status and photo paths.
    $sql_update = "UPDATE tasks SET status = ?, before_photo = ?, after_photo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssi", $status, $before_photo, $after_photo, $task_id);

    if ($stmt->execute()) {
        echo "Task updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Task</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Update Task: <?php echo htmlspecialchars($task['title']); ?></h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <option value="pending" <?php if($task['status'] == 'pending') echo 'selected'; ?>>Pending</option>
            <option value="in-progress" <?php if($task['status'] == 'in-progress') echo 'selected'; ?>>In Progress</option>
            <option value="completed" <?php if($task['status'] == 'completed') echo 'selected'; ?>>Completed</option>
        </select>
        <br><br>
        <label for="before_photo">Before Cleaning Photo:</label>
        <input type="file" name="before_photo" id="before_photo" accept="image/*">
        <br><br>
        <label for="after_photo">After Cleaning Photo:</label>
        <input type="file" name="after_photo" id="after_photo" accept="image/*">
        <br><br>
        <button type="submit">Update Task</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
