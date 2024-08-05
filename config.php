<?php
// Configuración para activar o desactivar mensajes de error
$show_errors = true;

if ($show_errors) {
    // Mostrar todos los errores
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // No mostrar errores
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Archivo de configuración
$servername = "localhost";
$username = "root";
$password = "J@m09679933";
$dbname = "medicalsystem";

// Conexión a la base de datos
$db = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$db) {
    die("La conexión falló: " . mysqli_connect_error());
}

// Configuración de PayPal
if (!defined('PAYPAL_CLIENT_ID')) {
    define('PAYPAL_CLIENT_ID', 'ARR9rFG5X8P1lfGnWr49CciOsYh_z9CUvodtwJnrvGhA7RggPiIun2o95XrFDw7rwGIfGMcXEufRQiy7');
}
if (!defined('PAYPAL_SECRET')) {
    define('PAYPAL_SECRET', 'EHyDcLCKLmuq1sK4xtQjMc_H9cCnA5LT_SCVybgMl2wzMJGEQDl2HS6WbZFqVlmIuQvoQB7AixDcF2b-');
}
if (!defined('PAYPAL_SETTINGS')) {
    define('PAYPAL_SETTINGS', [
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => __DIR__ . '/paypal.log',
        'log.LogLevel' => 'FINE'
    ]);
}
?>
