<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
// require 'config.php';

// function getUserById($user_id) {
//     global $db;
//     $sql = "SELECT * FROM users WHERE id = ?";
//     if ($stmt = mysqli_prepare($db, $sql)) {
//         mysqli_stmt_bind_param($stmt, "i", $param_id);
//         $param_id = $user_id;
//         if (mysqli_stmt_execute($stmt)) {
//             $result = mysqli_stmt_get_result($stmt);
//             if (mysqli_num_rows($result) == 1) {
//                 return mysqli_fetch_array($result, MYSQLI_ASSOC);
//             }
//         }
//     }
//     return null;
// }

// function updateUserPlan($user_id, $plan) {
//     global $db;
//     $sql = "UPDATE users SET plan = ? WHERE id = ?";
//     if ($stmt = mysqli_prepare($db, $sql)) {
//         mysqli_stmt_bind_param($stmt, "si", $param_plan, $param_id);
//         $param_plan = $plan;
//         $param_id = $user_id;
//         mysqli_stmt_execute($stmt);
//     }
// }

// $user_id = isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : null;
// $user = getUserById($user_id);

// if ($user && isset($user['plan']) && $user['plan'] === 'free' && strtotime($user['subscription_end_date']) < time()) {
//     updateUserPlan($user_id, 'free');
// }
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header style="background-color: #f7f7f7; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
        <div class="logo">
            <img src="img/logo.png" alt="Logo" style="width: 300px;">
        </div>
        <div class="user-info">
            <span style="margin-right: 10px;">Bienvenido, <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </header>
</body>
</html> -->





<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'config.php';

function getUserById($user_id) {
    global $db;
    $sql = "SELECT * FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                return mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
        }
    }
    return null;
}

function updateUserPlan($user_id, $plan) {
    global $db;
    $sql = "UPDATE users SET plan = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $plan, $user_id);
        mysqli_stmt_execute($stmt);
    }
}

$user_id = isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : null;
$user = getUserById($user_id);

if ($user && isset($user['plan']) && $user['plan'] === 'free' && strtotime($user['subscription_end_date']) < time()) {
    updateUserPlan($user_id, 'free');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Medical System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header style="background-color: #f7f7f7; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
        <div class="logo">
            <img src="img/logo.png" alt="Logo" style="width: 300px;">
        </div>
        <div class="user-info">
            <span style="margin-right: 10px;">Bienvenido, <?php echo htmlspecialchars($user['username'] ?? ''); ?></span>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </header>
</body>
</html>
