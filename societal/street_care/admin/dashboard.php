<?php
include '../includes/db.php';
session_start();

// Ensure only admins can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Inline styling for the admin dashboard navigation */
        nav {
            background-color: #333;
            padding: 10px;
            color: #fff;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }
        .container {
            margin: 20px auto;
            max-width: 1000px;
            padding: 20px;
            background: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <nav>
        <span>Admin Dashboard</span>
        <a href="assign_task.php">Assign Task</a>
        <a href="view_feedback.php">View Feedback</a>
        <a href="manage_tasks.php">Manage Tasks</a>
        <a href="../logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Welcome, Admin!</h2>
        <p>This dashboard allows you to oversee the operations of the Street Care Portal. Use the navigation menu above to:</p>
        <ul>
            <li><strong>Assign Tasks:</strong> Create and assign cleaning tasks to workers.</li>
            <li><strong>View Feedback:</strong> Review feedback and issues reported by residents.</li>
            <li><strong>Manage Tasks:</strong> Monitor the progress of tasks and review photo updates.</li>
        </ul>
    </div>
</body>
</html>

