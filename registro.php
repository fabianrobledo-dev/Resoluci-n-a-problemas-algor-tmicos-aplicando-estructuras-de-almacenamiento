<?php
include("config/db.php");

$mensaje = "";

if (isset($_POST['registrar'])) {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $usuario, $email, $password);

    if ($stmt->execute()) {
        $mensaje = "✅ Usuario registrado correctamente. Ahora puedes iniciar sesión.";
    } else {
        $mensaje = "❌ Error: el usuario ya existe o hubo un problema.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Sistema de Estudiantes</title>
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
    <div class="registro-card">
        <!-- Logo institucional -->
        <img src="./img/logo.png" alt="Logo">

        <h1>🆕 Crear Usuario</h1>

        <form method="POST">
            <input type="text" name="usuario" placeholder="👤 Usuario" required>
            <input type="email" name="email" placeholder="Correo Electronico" required>
            <input type="password" name="password" placeholder="🔑 Contraseña" required>
            <button type="submit" name="registrar" class="btn btn-registrar">Registrar</button>
        </form>

        <?php if (!empty($mensaje)) { ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php } ?>

        <a href="login.php" class="btn btn-login">🔙 Volver al Login</a>
    </div>
</body>
</html>
