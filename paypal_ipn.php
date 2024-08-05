<?php
include('config.php');

// Leer los datos de PayPal y verificar la IPN
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2) {
        $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
}

// Validar la IPN de PayPal
$req = 'cmd=_notify-validate';
foreach ($myPost as $key => $value) {
    $value = urlencode($value);
    $req .= "&$key=$value";
}

$ch = curl_init('https://ipnpb.sandbox.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

$res = curl_exec($ch);
curl_close($ch);

// Verificar la respuesta de PayPal
if (strcmp($res, "VERIFIED") == 0) {
    // Procesar la IPN
    $payment_status = $_POST['payment_status'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $user_id = $_POST['custom'];
    $plan = $_POST['item_name'];
    $amount = $_POST['mc_gross'];

    // Verificar que la transacción no se ha procesado antes
    $txn_id_check = mysqli_query($db, "SELECT txn_id FROM payments WHERE txn_id = '$txn_id'");
    if (mysqli_num_rows($txn_id_check) == 0) {
        // Insertar datos del pago en la base de datos
        $sql = "INSERT INTO payments (user_id, txn_id, payment_status, payment_amount, payer_email) VALUES ('$user_id', '$txn_id', '$payment_status', '$amount', '$payer_email')";
        mysqli_query($db, $sql);

        // Actualizar el plan del usuario
        if ($payment_status == "Completed") {
            $sql = "UPDATE users SET plan = '$plan' WHERE id = '$user_id'";
            mysqli_query($db, $sql);
        }
    }
}
?>
