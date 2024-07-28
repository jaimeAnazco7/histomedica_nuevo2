<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'patient') {
    header("location: login.php");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['login_user_id'];
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
    $emergency_contact_name = mysqli_real_escape_string($db, $_POST['emergency_contact_name']);
    $emergency_contact_phone = mysqli_real_escape_string($db, $_POST['emergency_contact_phone']);
    $lens_measurements = mysqli_real_escape_string($db, $_POST['lens_measurements']);
    $chronic_diseases = mysqli_real_escape_string($db, $_POST['chronic_diseases']);
    
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_path = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }

    // Actualizar la tabla de pacientes
    $sql_update = "UPDATE patients SET 
                    first_name = '$first_name',
                    last_name = '$last_name',
                    date_of_birth = '$date_of_birth',
                    gender = '$gender',
                    marital_status = '$marital_status',
                    age = '$age',
                    weight = '$weight',
                    blood_type = '$blood_type',
                    phone = '$phone',
                    address = '$address',
                    email = '$email',
                    emergency_contact_name = '$emergency_contact_name',
                    emergency_contact_phone = '$emergency_contact_phone',
                    lens_measurements = '$lens_measurements',
                    chronic_diseases = '$chronic_diseases'";
    if ($photo_path) {
        $sql_update .= ", photo_path = '$photo_path'";
    }
    $sql_update .= " WHERE user_id = '$user_id'";
    
    if (mysqli_query($db, $sql_update)) {
        // Obtener el ID del paciente
        $sql_get_patient_id = "SELECT id FROM patients WHERE user_id = '$user_id'";
        $result = mysqli_query($db, $sql_get_patient_id);
        if ($result && mysqli_num_rows($result) > 0) {
            $patient = mysqli_fetch_assoc($result);
            $patient_id = $patient['id'];

            // Eliminar subcategorías anteriores
            $sql_delete_subcategories = "DELETE FROM patient_subcategories WHERE patient_id = '$patient_id'";
            mysqli_query($db, $sql_delete_subcategories);

            // Insertar o actualizar subcategorías
            if (!empty($_POST['subcategories'])) {
                $subcategory_ids = $_POST['subcategories'];
                foreach ($subcategory_ids as $subcategory_id) {
                    $observations = '';
                    if (isset($_POST['observations'][$subcategory_id])) {
                        $observations = mysqli_real_escape_string($db, $_POST['observations'][$subcategory_id]);
                    }

                    $sql_insert_subcategory = "INSERT INTO patient_subcategories (patient_id, subcategory_id, observations) 
                                               VALUES ('$patient_id', '$subcategory_id', '$observations')
                                               ON DUPLICATE KEY UPDATE observations = VALUES(observations)";
                    mysqli_query($db, $sql_insert_subcategory);
                }
            }

            $_SESSION['success'] = "Datos del paciente actualizados correctamente";
        } else {
            $_SESSION['error'] = "Error al obtener el ID del paciente.";
        }
    } else {
        $_SESSION['error'] = "Error al actualizar los datos del paciente: " . mysqli_error($db);
    }
    
    header("location: dashboard_patient.php");
}
?>
