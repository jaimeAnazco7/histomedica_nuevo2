<?php include('header.php'); ?>
<?php
session_start();
include('config.php');

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'patient') {
    header("location: login.php");
    die();
}

if (isset($_GET['id'])) {
    $family_member_id = $_GET['id'];

    // Obtener datos del familiar
    $sql = "SELECT * FROM family_members WHERE id = '$family_member_id'";
    $result = mysqli_query($db, $sql);
    $family_member_data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    // Verificar si las claves existen en el array, si no, inicializarlas a un valor vacío
    $family_member_data['gender'] = isset($family_member_data['gender']) ? $family_member_data['gender'] : '';
    $family_member_data['marital_status'] = isset($family_member_data['marital_status']) ? $family_member_data['marital_status'] : '';
    $family_member_data['address'] = isset($family_member_data['address']) ? $family_member_data['address'] : '';
    $family_member_data['observations'] = isset($family_member_data['observations']) ? $family_member_data['observations'] : '';
} else {
    $_SESSION['error'] = "ID de familiar no proporcionado";
    header("location: dashboard_patient.php");
    die();
}
?>

<div class="container">
    <h2>Editar Información del Familiar</h2>
    <form action="update_family_data.php" method="post">
        <label>Nombre</label>
        <input type="text" name="first_name" value="<?php echo $family_member_data['first_name']; ?>" required>
        <label>Apellido Paterno</label>
        <input type="text" name="last_name" value="<?php echo $family_member_data['last_name']; ?>" required>
        <label>Fecha de Nacimiento</label>
        <input type="date" name="date_of_birth" value="<?php echo $family_member_data['date_of_birth']; ?>" required>
        <label>Género</label>
        <select name="gender" required>
            <option value="Masculino" <?php if ($family_member_data['gender'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
            <option value="Femenino" <?php if ($family_member_data['gender'] == 'Femenino') echo 'selected'; ?>>Femenino</option>
        </select>
        <label>Estado Civil</label>
        <select name="marital_status" required>
            <option value="Casado" <?php if ($family_member_data['marital_status'] == 'Casado') echo 'selected'; ?>>Casado</option>
            <option value="Soltero" <?php if ($family_member_data['marital_status'] == 'Soltero') echo 'selected'; ?>>Soltero</option>
        </select>
        <label>Edad</label>
        <input type="number" name="age" value="<?php echo $family_member_data['age']; ?>" required>
        <label>Peso (Kg)</label>
        <input type="number" step="any" name="weight" value="<?php echo $family_member_data['weight']; ?>" required>
        <label>Tipo de Sangre</label>
        <input type="text" name="blood_type" value="<?php echo $family_member_data['blood_type']; ?>" required>
        <label>Teléfono</label>
        <input type="tel" name="phone" value="<?php echo $family_member_data['phone']; ?>" required>
        <label>Dirección</label>
        <textarea name="address" required><?php echo $family_member_data['address']; ?></textarea>
        <label>Correo Electrónico</label>
        <input type="email" name="email" value="<?php echo $family_member_data['email']; ?>" required>
        <label>Relación con el Paciente</label>
        <input type="text" name="relationship" value="<?php echo $family_member_data['relationship']; ?>" required>
        <label>Prescripción de Lentes</label>
        <input type="text" name="lens_prescription" value="<?php echo $family_member_data['lens_prescription']; ?>" required>
        <label>Categoría Crónica</label>
        <input type="text" name="chronic_category" value="<?php echo $family_member_data['chronic_category']; ?>" required>
        <label>Subcategoría Crónica</label>
        <input type="text" name="chronic_subcategory" value="<?php echo $family_member_data['chronic_subcategory']; ?>" required>
        <label>Observaciones</label>
        <textarea name="observations"><?php echo $family_member_data['observations']; ?></textarea>
        <input type="hidden" name="family_member_id" value="<?php echo $family_member_data['id']; ?>">
        <input type="submit" value="Actualizar">
    </form>
</div>
</body>
</html>
