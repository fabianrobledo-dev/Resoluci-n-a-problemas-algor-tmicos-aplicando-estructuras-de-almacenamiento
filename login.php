<?php
session_start();
include("config/db.php");

$error = "";

if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Guardamos TODOS los datos en la sesión
            $_SESSION['usuario'] = [
                'id' => $row['id'],
                'usuario' => $row['usuario'],
                'email' => $row['email'] ?? '' // si tienes el campo email
            ];

            header("Location: index.php");
            exit();
        } else {
            $error = "❌ Contraseña incorrecta.";
        }
    } else {
        $error = "❌ El usuario no existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Estudiantes</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
       
    </style>
</head>
<body>
    <div class="login-card">
        <!-- Logo institucional (puedes cambiarlo por el del SENA o tu proyecto) -->
        <img src="img/logo.png" alt="Logo">

        <h1>🔐 Iniciar Sesión</h1>

        <form method="POST">
            <input type="text" name="usuario" placeholder="👤 Usuario" required>
            <input type="password" name="password" placeholder="🔑 Contraseña" required>
            <button type="submit" name="login" class="btn btn-login">Entrar</button>
        </form>

        <?php if (!empty($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <a href="registro.php" class="btn btn-registro">Crear Usuario</a>
    </div>
</body>
</html>
