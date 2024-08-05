<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $subscriptionID = $data['subscriptionID'];
    $userID = $data['user_id'];
    $plan = $data['plan'];

    // Obtener la fecha actual y la fecha de finalización de la suscripción (por ejemplo, 1 mes después)
    $start_date = date('Y-m-d H:i:s');
    $end_date = date('Y-m-d H:i:s', strtotime('+1 month'));

    // Actualizar el plan del usuario y registrar la suscripción
    $sql_update_user = "UPDATE users SET plan='$plan', subscription_id='$subscriptionID' WHERE id='$userID'";
    $sql_insert_subscription = "INSERT INTO subscriptions (user_id, subscription_id, plan, status, start_date, end_date) VALUES ('$userID', '$subscriptionID', '$plan', 'active', '$start_date', '$end_date')";

    if (mysqli_query($db, $sql_update_user) && mysqli_query($db, $sql_insert_subscription)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'error' => mysqli_error($db)]);
    }
}
?>
