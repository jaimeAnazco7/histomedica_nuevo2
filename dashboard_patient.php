<?php
session_start();
include('header.php');
include('config.php');

if (!isset($_SESSION['login_user']) || $_SESSION['user_role'] != 'patient') {
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['login_user_id'];

// Verificar la conexión a la base de datos
if (!$db) {
    $_SESSION['error'] = "Error al conectar a la base de datos";
    header("location: login.php");
    exit();
}

// Obtener datos del paciente
$sql_patient = "SELECT * FROM patients WHERE user_id = '$user_id'";
$result_patient = mysqli_query($db, $sql_patient);
if ($result_patient && mysqli_num_rows($result_patient) > 0) {
    $patient_data = mysqli_fetch_assoc($result_patient);
} else {
    $_SESSION['error'] = "No se encontraron datos del paciente";
    header("location: dashboard_patient.php");
    exit();
}

// Obtener familiares
$sql_family = "SELECT * FROM family_members WHERE patient_id = '{$patient_data['id']}'";
$result_family = mysqli_query($db, $sql_family);
$family_data = mysqli_fetch_all($result_family, MYSQLI_ASSOC);

// Obtener subcategorías del paciente
$sql_subcategories = "SELECT subcategory_id, observations FROM patient_subcategories WHERE patient_id = '{$patient_data['id']}'";
$result_subcategories = mysqli_query($db, $sql_subcategories);
$patient_subcategories = [];
while ($row = mysqli_fetch_assoc($result_subcategories)) {
    $patient_subcategories[$row['subcategory_id']] = $row['observations'];
}

// Obtener todas las categorías y subcategorías
$sql_categories = "SELECT c.id as category_id, c.name as category_name, s.id as subcategory_id, s.name as subcategory_name
                   FROM categories c
                   LEFT JOIN subcategories s ON c.id = s.category_id";
$result_categories = mysqli_query($db, $sql_categories);
$categories = [];
while ($row = mysqli_fetch_assoc($result_categories)) {
    $categories[$row['category_id']]['name'] = $row['category_name'];
    $categories[$row['category_id']]['subcategories'][] = [
        'id' => $row['subcategory_id'],
        'name' => $row['subcategory_name']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Medical System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container-flex {
            display: flex;
            gap: 20px;
        }
        .form-group {
            flex: 1;
            width: 40%;
        }
        .subcategory-container-wrapper {
            flex: 1;
            width: 60%;
        }
        .subcategory-container {
            margin-bottom: 15px;
        }
        h1, h2 {
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['login_user']); ?></h1>
        
        <h2>Datos del Paciente</h2>
        <form action="update_patient_data.php" method="post" enctype="multipart/form-data">
            <label for="first_name">Nombre:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($patient_data['first_name']); ?>" placeholder="Nombre" required>

            <label for="last_name">Apellido:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($patient_data['last_name']); ?>" placeholder="Apellido" required>

            <label for="date_of_birth">Fecha de nacimiento:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($patient_data['date_of_birth']); ?>" required>

            <label for="gender">Género:</label>
            <select id="gender" name="gender" required>
                <option value="Masculino" <?php if ($patient_data['gender'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
                <option value="Femenino" <?php if ($patient_data['gender'] == 'Femenino') echo 'selected'; ?>>Femenino</option>
            </select>

            <label for="marital_status">Estado civil:</label>
            <select id="marital_status" name="marital_status" required>
                <option value="Casado" <?php if ($patient_data['marital_status'] == 'Casado') echo 'selected'; ?>>Casado</option>
                <option value="Soltero" <?php if ($patient_data['marital_status'] == 'Soltero') echo 'selected'; ?>>Soltero</option>
            </select>

            <label for="age">Edad:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($patient_data['age']); ?>" placeholder="Edad" required>

            <label for="weight">Peso:</label>
            <input type="number" step="0.01" id="weight" name="weight" value="<?php echo htmlspecialchars($patient_data['weight']); ?>" placeholder="Peso" required>

            <label for="blood_type">Tipo de sangre:</label>
            <input type="text" id="blood_type" name="blood_type" value="<?php echo htmlspecialchars($patient_data['blood_type']); ?>" placeholder="Tipo de sangre" required>

            <label for="phone">Teléfono:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($patient_data['phone']); ?>" placeholder="Teléfono" required>

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($patient_data['address']); ?>" placeholder="Dirección" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient_data['email']); ?>" placeholder="Correo electrónico" required>

            <label for="emergency_contact_name">Nombre del contacto de emergencia:</label>
            <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo htmlspecialchars($patient_data['emergency_contact_name']); ?>" placeholder="Nombre del contacto de emergencia" required>

            <label for="emergency_contact_phone">Teléfono del contacto de emergencia:</label>
            <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo htmlspecialchars($patient_data['emergency_contact_phone']); ?>" placeholder="Teléfono del contacto de emergencia" required>

            <label for="lens_measurements">Medida de lentes:</label>
            <input type="text" id="lens_measurements" name="lens_measurements" value="<?php echo htmlspecialchars($patient_data['lens_measurements']); ?>" placeholder="Medida de lentes" required>

            <label for="chronic_diseases">Enfermedades crónicas:</label>
            <textarea id="chronic_diseases" name="chronic_diseases" placeholder="Enfermedades crónicas" required><?php echo htmlspecialchars($patient_data['chronic_diseases']); ?></textarea>

            <label for="photo">Foto del Paciente:</label>
            <input type="file" id="photo" name="photo" accept="image/*">
            
            <h3>Categorías y Subcategorías</h3>
            <?php foreach ($categories as $category_id => $category): ?>
                <?php if ($category['name'] == 'Ginecológicas'): ?>
                    <div class="container-flex">
                        <div class="form-group">
                            <label><?php echo htmlspecialchars($category['name']); ?>:</label>
                            <select name="subcategories[]" multiple>
                                <?php foreach ($category['subcategories'] as $subcategory): ?>
                                    <option value="<?php echo $subcategory['id']; ?>"
                                        <?php if (array_key_exists($subcategory['id'], $patient_subcategories)) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($subcategory['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="subcategory-container-wrapper">
                            <?php foreach ($category['subcategories'] as $subcategory): ?>
                                <div class="subcategory-container">
                                    <button type="button" class="btn btn-info observation-button" onclick="toggleObservation(<?php echo $subcategory['id']; ?>)">Mostrar/Ocultar Observaciones</button>
                                    <textarea id="observations-<?php echo $subcategory['id']; ?>" name="observations[<?php echo $subcategory['id']; ?>]" placeholder="Ingrese observaciones aquí" style="display:none;"><?php echo htmlspecialchars($patient_subcategories[$subcategory['id']] ?? ''); ?></textarea>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <label><?php echo htmlspecialchars($category['name']); ?>:</label>
                    <select name="subcategories[]" multiple>
                        <?php foreach ($category['subcategories'] as $subcategory): ?>
                            <option value="<?php echo $subcategory['id']; ?>"
                                <?php if (array_key_exists($subcategory['id'], $patient_subcategories)) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($subcategory['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            <?php endforeach; ?>
            <input type="submit" value="Actualizar">
        </form>

        <?php if (!empty($patient_data['photo_path'])): ?>
            <h2>Foto del Paciente</h2>
            <img src="<?php echo htmlspecialchars($patient_data['photo_path']); ?>" alt="Foto del Paciente" style="width: 150px; height: auto;">
        <?php endif; ?>

        <h2>Familiares</h2>
        <ul>
            <?php foreach ($family_data as $family_member): ?>
                <li>
                    <?php echo htmlspecialchars($family_member['first_name']) . ' ' . htmlspecialchars($family_member['last_name']); ?>
                    <button onclick="location.href='edit_family_data.php?id=<?php echo $family_member['id']; ?>'">Editar</button>
                    <button onclick="location.href='delete_family_data.php?id=<?php echo $family_member['id']; ?>'">Eliminar</button>
                </li>
            <?php endforeach; ?>
        </ul>
        <button onclick="location.href='add_family_data.php'">Agregar Familiar</button>
    </div>

    <script>
        function toggleObservation(subcategoryId) {
            var textarea = document.getElementById('observations-' + subcategoryId);
            if (textarea.style.display === 'none') {
                textarea.style.display = 'block';
            } else {
                textarea.style.display = 'none';
            }
        }
    </script>
</body>
</html>
