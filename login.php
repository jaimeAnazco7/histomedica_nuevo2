<?php
session_start();
include('config.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']); 

    $sql = "SELECT id, role, username FROM users WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION['login_user'] = $username;
        $_SESSION['user_role'] = $row['role'];
        $_SESSION['login_user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("location: dashboard.php");
    } else {
        $error = "Tu nombre de usuario o contraseña es inválido";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Medical System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #f7f7f7;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container input[type="submit"] {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="img/logo.png" alt="Logo" style="width: 100px;">
        <h2>Plataforma de Gestión para registrar tus Datos médicos</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <select name="language" required>
                <option value="es">Por Defecto - Español (Latín América)</option>
                <!-- Añadir otros idiomas según sea necesario -->
            </select>
            <input type="submit" value="Iniciar sesión">
        </form>
        <p><a href="register.php">Registrarse</a></p>
        <?php if(isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    </div>
</body>
</html>
