<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user_id']) || !isset($_GET['tx']) || !isset($_GET['st']) || $_GET['st'] != 'Completed') {
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['login_user_id'];
$plan = $_SESSION['plan'];

// Actualizar el plan del usuario en la base de datos
$sql = "UPDATE users SET plan = '$plan' WHERE id = '$user_id'";
if (mysqli_query($db, $sql)) {
    // Registro del pago en la base de datos
    $txn_id = $_GET['tx'];
    $payment_status = $_GET['st'];
    $payment_amount = $_GET['amt'];
    $payer_email = $_GET['payer_email'];
    
    $sql_payment = "INSERT INTO payments (user_id, txn_id, payment_status, payment_amount, payer_email) VALUES ('$user_id', '$txn_id', '$payment_status', '$payment_amount', '$payer_email')";
    mysqli_query($db, $sql_payment);

    header("location: dashboard_patient.php");
    exit();
} else {
    echo "Error al actualizar el plan del usuario: " . mysqli_error($db);
}
?>
