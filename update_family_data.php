<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'patient') {
    header("location: login.php");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $family_member_id = mysqli_real_escape_string($db, $_POST['family_member_id']);
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

    $sql = "UPDATE family_members SET first_name = '$first_name', last_name = '$last_name', date_of_birth = '$date_of_birth', gender = '$gender', marital_status = '$marital_status', age = '$age', weight = '$weight', blood_type = '$blood_type', phone = '$phone', address = '$address', email = '$email', relationship = '$relationship', lens_prescription = '$lens_prescription', chronic_category = '$chronic_category', chronic_subcategory = '$chronic_subcategory', observations = '$observations' WHERE id = '$family_member_id'";

    if (mysqli_query($db, $sql)) {
        $_SESSION['message'] = "Datos actualizados correctamente";
        header("location: dashboard_patient.php");
    } else {
        $_SESSION['error'] = "Error al actualizar los datos";
        header("location: dashboard_patient.php");
    }
}
?>
