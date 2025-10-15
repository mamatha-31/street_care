<?php
include '../includes/db.php';
session_start();

// Ensure only admins can access this page.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Retrieve list of workers.
$sql = "SELECT id, name FROM users WHERE role='worker'";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $assigned_to = $_POST['assigned_to'];

    // Insert the new task into the tasks table.
    $sql_insert = "INSERT INTO tasks (title, description, assigned_to) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssi", $title, $description, $assigned_to);

    if ($stmt->execute()) {
        echo "Task assigned successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Task</title>
    <style>        /* Apply styles to all elements */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://assets.telegraphindia.com/telegraph/e3435f0f-3096-4b22-a47b-700344530350.jpg'); /* Updated background */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Main container for form */
        .container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Animation for smooth appearance */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Title style */
        h1 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #fff;
        }

        /* Input and textarea styling */
        input[type="text"], textarea, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        /* Textarea specific style */
        textarea {
            resize: none;
            height: 100px;
        }

        /* Dropdown and select styling */
        select {
            background-color: #fff;
        }

        /* Button styles */
        button {
            width: 100%;
            padding: 12px 18px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Back to dashboard link */
        .back-link {
            display: block;
            margin-top: 15px;
            text-align: center;
            color: #f0f0f0;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <h2>Assign Task</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Task Title" required>
        <textarea name="description" placeholder="Task Description" required></textarea>
        <select name="assigned_to" required>
            <option value="">Select Worker</option>
            <?php while($worker = $result->fetch_assoc()): ?>
                <option value="<?php echo $worker['id']; ?>"><?php echo $worker['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Assign Task</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
