
<?php
$servername = "localhost";
$username = "root";
$password = "J@m09679933";
$dbname = "MedicalSystem";

// Crear la conexión
$db = mysqli_connect($servername, $username, $password, $dbname);

// Verificar la conexión
if (!$db) {
    die("La conexión falló: " . mysqli_connect_error());
}
?>
