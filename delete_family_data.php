<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'patient') {
    header("location: login.php");
    die();
}

if (isset($_GET['id'])) {
    $family_member_id = $_GET['id'];

    // Eliminar familiar
    $sql = "DELETE FROM family_members WHERE id = '$family_member_id'";
    
    if (mysqli_query($db, $sql)) {
        $_SESSION['message'] = "Familiar eliminado correctamente";
        header("location: dashboard_patient.php");
    } else {
        $_SESSION['error'] = "Error al eliminar familiar";
        header("location: dashboard_patient.php");
    }
} else {
    $_SESSION['error'] = "ID de familiar no proporcionado";
    header("location: dashboard_patient.php");
    die();
}
?>
