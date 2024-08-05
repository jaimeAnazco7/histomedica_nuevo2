<?php
session_start();
include('config.php');

if (isset($_SESSION['login_user_id'])) {
    $user_id = $_SESSION['login_user_id'];

    // Eliminar el usuario y el paciente si el pago fue cancelado
    $sql_user = "DELETE FROM users WHERE id = '$user_id'";
    $sql_patient = "DELETE FROM patients WHERE user_id = '$user_id'";
    mysqli_query($db, $sql_user);
    mysqli_query($db, $sql_patient);

    unset($_SESSION['login_user']);
    unset($_SESSION['login_user_id']);
    unset($_SESSION['user_role']);
}

header("location: register.php");
exit();
?>
