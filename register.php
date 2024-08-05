<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $plan = mysqli_real_escape_string($db, $_POST['plan']);

    // Inserción en la tabla de usuarios
    $sql_user = "INSERT INTO users (username, password, role, plan) VALUES ('$username', '$password', 'patient', '$plan')";
    if (mysqli_query($db, $sql_user)) {
        $user_id = mysqli_insert_id($db);

        // Inserción en la tabla de pacientes
        $sql_patient = "INSERT INTO patients (user_id, first_name, last_name, email) VALUES ('$user_id', '$first_name', '$last_name', '$email')";
        if (mysqli_query($db, $sql_patient)) {
            $_SESSION['login_user'] = $username;
            $_SESSION['user_role'] = 'patient';
            $_SESSION['login_user_id'] = $user_id;
            $_SESSION['plan'] = $plan;

            // Redirigir a la página de pago si el plan es Silver o Gold
            if ($plan == 'silver' || $plan == 'gold') {
                header("location: paypal_payment.php?plan=$plan&user_id=$user_id");
                exit();
            }

            // Redirigir al dashboard para el plan free
            header("location: dashboard_patient.php");
            exit();
        } else {
            echo "Error al registrar el paciente: " . mysqli_error($db);
        }
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($db);
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
        .register-container input[type="password"],
        .register-container input[type="email"],
        .register-container select {
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
        <h2>Registro de nuevo usuario</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="text" name="first_name" placeholder="Nombre" required>
            <input type="text" name="last_name" placeholder="Apellido" required>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <select name="plan" required>
                <option value="free">Gratis</option>
                <option value="silver">Silver</option>
                <option value="gold">Gold</option>
            </select>
            <input type="submit" value="Registrar">
        </form>
        <p><a href="login.php">Iniciar sesión</a></p>
    </div>
</body>
</html>
