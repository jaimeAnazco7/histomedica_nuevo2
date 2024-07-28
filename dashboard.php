<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user'])) {
    header("location: login.php");
    die();
}

$role = $_SESSION['user_role'];

if ($role == 'patient') {
    header("location: dashboard_patient.php");
    die();
}

$username = $_SESSION['login_user'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Medical System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo $username; ?></h1>
        <p>Rol: <?php echo $role; ?></p>
        
        <!-- Aquí iría el contenido del dashboard para otros roles (admin, etc.) -->
    </div>
</body>
</html>
