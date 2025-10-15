<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Street Care Operation Portal</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
    /* General body styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: url('https://media.istockphoto.com/id/916291672/photo/indian-women-cleaning-road-in-the-street.jpg?s=612x612&w=0&k=20&c=qWEwLDOVEjpQsZz5m3R6jviuJz6Z8FB7QXR3av2K9vc=') no-repeat center center/cover;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
        }
        
        /* Sidebar navigation */
        .sidebar {
            width: 250px;
            background: rgba(0, 0, 0, 0.8);
            height: 100vh;
            padding: 20px;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.5);
        }
        
        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .sidebar a {
            display: block;
            color: #fff;
            padding: 12px;
            margin-bottom: 10px;
            text-decoration: none;
            border-bottom: 1px solid #555;
            transition: all 0.3s ease;
        }
        
        .sidebar a:hover {
            background: #28a745;
            padding-left: 20px;
            box-shadow: 0 0 10px #28a745;
        }
        
        /* Main container layout */
        .container {
            flex: 1;
            display: flex;
            justify-content: space-between;
            padding: 50px;
        }
        
        /* Login & Register Box */
        .auth-box {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }
        
        .auth-box h2 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .auth-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            outline: none;
        }
        
        .auth-box button {
            width: 100%;
            padding: 12px;
            background: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease-in-out;
        }
        
        .auth-box button:hover {
            background: #45a049;
            box-shadow: 0 0 15px #4caf50;
            transform: scale(1.05);
        }
        
        /* Welcome message on the right */
        .welcome-box {
            width: 300px;
            text-align: center;
            color: #fff;
            margin-top: 50px;
        }
        
        .welcome-box h1 {
            font-size: 36px;
            animation: glow 1.5s infinite alternate;
        }
        
        /* Glow effect */
        @keyframes glow {
            0% { text-shadow: 0 0 10px #fff, 0 0 20px #ff4081, 0 0 30px #ff4081; }
            100% { text-shadow: 0 0 20px #fff, 0 0 30px #ff4081, 0 0 40px #ff4081; }
        }
        
        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
        
            .sidebar {
                width: 100%;
                height: auto;
            }
        
            .auth-box {
                width: 100%;
                margin-top: 20px;
            }
        
            .welcome-box {
                width: 100%;
                margin-top: 20px;
            }
        }
        </style>
</head>
<body>

    <h1>Welcome to Street Care Operation Portal</h1>
    <p>A platform for municipal cleaning operations.</p>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p>You are logged in as <strong><?php echo $_SESSION['role']; ?></strong>.</p>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="admin/dashboard.php">Go to Admin Dashboard</a>
        <?php elseif ($_SESSION['role'] === 'worker'): ?>
            <a href="worker/dashboard.php">Go to Worker Dashboard</a>
        <?php else: ?>
            <a href="resident/dashboard.php">Go to Resident Dashboard</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> |
        <a href="register.php">Register</a>
    <?php endif; ?>

</body>
</html>
