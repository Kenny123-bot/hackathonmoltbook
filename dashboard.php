<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: auth/login.php");
    exit;
}

$name = htmlspecialchars($_SESSION['name']);
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #e8ecf1);
            padding: 30px;
        }

        .card {
            max-width: 480px;
            margin: 60px auto;
            background: #fff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            text-align: center;
            animation: fadeIn 0.6s ease;
        }

        h2 {
            margin-top: 0;
        }

        .role {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 10px 0 20px;
        }

        .admin { background: #e74c3c; color: #fff; }
        .judge { background: #2980b9; color: #fff; }
        .participant { background: #27ae60; color: #fff; }

        .actions a {
            display: block;
            margin: 10px 0;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .actions a:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: #2c3e50;
            color: #fff;
        }

        .btn-logout {
            background: #bdc3c7;
            color: #2c3e50;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="card">
    <h2>👋 Welcome, <?= $name ?></h2>

    <div class="role <?= $role ?>">
        <?= ucfirst($role) ?>
    </div>

    <div class="actions">
        <?php if ($role === 'admin'): ?>
            <a href="admin/dashboard.php" class="btn-primary">⚙️ Admin Dashboard</a>
        <?php endif; ?>

        <?php if ($role === 'judge'): ?>
            <a href="judge/dashboard.php" class="btn-primary">🧮 Judge Panel</a>
        <?php endif; ?>

        <?php if ($role === 'participant'): ?>
            <a href="participant/dashboard.php" class="btn-primary">🚀 My Projects</a>
        <?php endif; ?>

        <a href="auth/logout.php" class="btn-logout">🚪 Logout</a>
    </div>
</div>

</body>
</html>
