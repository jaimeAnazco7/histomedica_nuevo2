

<?php
include('config.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $role = 'patient'; // Todos los registrados serán pacientes

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if(mysqli_query($db, $sql)) {
        header("location: login.php");
    } else {
        $error = "Error al registrarse";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Medical System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: #f7f7f7;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .register-container h2 {
            margin-bottom: 20px;
        }
        .register-container input[type="text"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .register-container input[type="submit"] {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .register-container input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="img/logo.png" alt="Logo" style="width: 100px;">
        <h2>Registrar</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="submit" value="Registrarse">
        </form>
        <p><a href="login.php">Iniciar sesión</a></p>
    </div>
</body>
</html>

