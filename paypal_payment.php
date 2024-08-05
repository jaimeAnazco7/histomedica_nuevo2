<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'patient') {
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['login_user_id'];
$plan = isset($_GET['plan']) ? $_GET['plan'] : 'free';

if ($plan === 'free') {
    // Actualizar el plan del usuario en la base de datos
    $sql = "UPDATE users SET plan = 'free' WHERE id = '$user_id'";
    if (mysqli_query($db, $sql)) {
        // Redirigir al dashboard
        header("location: dashboard_patient.php");
        exit();
    } else {
        echo "Error al actualizar el plan del usuario: " . mysqli_error($db);
    }
} elseif ($plan !== 'silver' && $plan !== 'gold') {
    header("location: dashboard.php");
    exit();
}

// Determinar el plan_id de PayPal y el contenedor según el plan
$plan_id = '';
$container_id = '';
if ($plan === 'silver') {
    $plan_id = 'P-498690331M628230AM2X6KOQ';
    $container_id = 'paypal-button-container-silver';
} elseif ($plan === 'gold') {
    $plan_id = 'P-69E81300SP9787800M2YLEZI';
    $container_id = 'paypal-button-container-gold';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago con PayPal</title>
    <script src="https://www.paypal.com/sdk/js?client-id=ARR9rFG5X8P1lfGnWr49CciOsYh_z9CUvodtwJnrvGhA7RggPiIun2o95XrFDw7rwGIfGMcXEufRQiy7&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
</head>
<body>
    <!-- Botón de Suscripción de PayPal -->
    <div id="<?php echo $container_id; ?>"></div>
    <script>
      paypal.Buttons({
          style: {
              shape: 'rect',
              color: 'gold',
              layout: 'vertical',
              label: 'subscribe'
          },
          createSubscription: function(data, actions) {
            return actions.subscription.create({
              /* Crea la suscripción */
              plan_id: '<?php echo $plan_id; ?>' // Usa el ID del plan que hayas configurado en tu cuenta de Sandbox
            });
          },
          onApprove: function(data, actions) {
            // Realiza una llamada AJAX para guardar la ID de la suscripción en la base de datos
            fetch('paypal_subscription_success.php', {
                method: 'post',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify({
                    subscriptionID: data.subscriptionID,
                    plan: '<?php echo $plan; ?>',
                    user_id: <?php echo $user_id; ?>
                })
            }).then(function(response) {
                return response.json();
            }).then(function(details) {
                if (details.status === 'success') {
                    window.location.href = 'dashboard_patient.php';
                } else {
                    alert('Error al actualizar la base de datos.');
                }
            });
          }
      }).render('#<?php echo $container_id; ?>'); // Renderiza el botón de PayPal
    </script>
</body>
</html>
