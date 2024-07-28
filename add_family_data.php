<?php
include('header.php');
session_start();
include('config.php');

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'patient') {
    header("location: login.php");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el user_id del paciente actualmente autenticado
    $user_id = $_SESSION['login_user_id'];

    // Obtener datos del formulario
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $date_of_birth = mysqli_real_escape_string($db, $_POST['date_of_birth']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $marital_status = mysqli_real_escape_string($db, $_POST['marital_status']);
    $age = mysqli_real_escape_string($db, $_POST['age']);
    $weight = mysqli_real_escape_string($db, $_POST['weight']);
    $blood_type = mysqli_real_escape_string($db, $_POST['blood_type']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $relationship = mysqli_real_escape_string($db, $_POST['relationship']);
    $lens_prescription = mysqli_real_escape_string($db, $_POST['lens_prescription']);
    $chronic_category = mysqli_real_escape_string($db, $_POST['chronic_category']);
    $chronic_subcategory = mysqli_real_escape_string($db, $_POST['chronic_subcategory']);
    $observations = mysqli_real_escape_string($db, $_POST['observations']);

    // Verificar si el user_id existe en la tabla patients
    $check_patient_sql = "SELECT * FROM patients WHERE user_id = '$user_id'";
    $result = mysqli_query($db, $check_patient_sql);

    if (mysqli_num_rows($result) > 0) {
        // Obtener el id del paciente correspondiente
        $patient_data = mysqli_fetch_assoc($result);
        $patient_id = $patient_data['id'];

        // Insertar el familiar con el patient_id obtenido
        $sql = "INSERT INTO family_members (patient_id, first_name, last_name, date_of_birth, gender, marital_status, age, weight, blood_type, phone, address, email, relationship, lens_prescription, chronic_category, chronic_subcategory, observations) VALUES ('$patient_id', '$first_name', '$last_name', '$date_of_birth', '$gender', '$marital_status', '$age', '$weight', '$blood_type', '$phone', '$address', '$email', '$relationship', '$lens_prescription', '$chronic_category', '$chronic_subcategory', '$observations')";

        if (mysqli_query($db, $sql)) {
            $_SESSION['message'] = "Nuevo familiar agregado correctamente";
            header("location: dashboard_patient.php");
        } else {
            $_SESSION['error'] = "Error al agregar nuevo familiar: " . mysqli_error($db);
            header("location: dashboard_patient.php");
        }
    } else {
        $_SESSION['error'] = "ID de usuario no encontrado en la tabla de pacientes";
        header("location: dashboard_patient.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Familiar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Familiar</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['message'])) {
            echo "<div class='message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        ?>
        <form method="POST" action="add_family_data.php">
            <div class="form-group">
                <label for="first_name">Nombre:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Apellido:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Fecha de Nacimiento:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="form-group">
                <label for="gender">Género:</label>
                <select id="gender" name="gender" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="marital_status">Estado Civil:</label>
                <select id="marital_status" name="marital_status" required>
                    <option value="Casado">Casado</option>
                    <option value="Soltero">Soltero</option>
                </select>
            </div>
            <div class="form-group">
                <label for="age">Edad:</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="weight">Peso:</label>
                <input type="number" step="0.1" id="weight" name="weight" required>
            </div>
            <div class="form-group">
                <label for="blood_type">Tipo de Sangre:</label>
                <input type="text" id="blood_type" name="blood_type" required>
            </div>
            <div class="form-group">
                <label for="phone">Teléfono:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Dirección:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="relationship">Relación:</label>
                <input type="text" id="relationship" name="relationship" required>
            </div>
            <div class="form-group">
                <label for="lens_prescription">Prescripción de Lentes:</label>
                <input type="text" id="lens_prescription" name="lens_prescription" required>
            </div>
            <div class="form-group">
                <label for="chronic_category">Categoría Crónica:</label>
                <input type="text" id="chronic_category" name="chronic_category" required>
            </div>
            <div class="form-group">
                <label for="chronic_subcategory">Subcategoría Crónica:</label>
                <input type="text" id="chronic_subcategory" name="chronic_subcategory" required>
            </div>
            <div class="form-group">
                <label for="observations">Observaciones:</label>
                <textarea id="observations" name="observations" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Agregar Familiar</button>
            </div>
        </form>
    </div>
</body>
</html>
