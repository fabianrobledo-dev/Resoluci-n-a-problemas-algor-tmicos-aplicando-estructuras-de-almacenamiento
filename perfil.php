<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once("config/db.php");

$id = $_SESSION['usuario']['id'];

// Obtener datos actuales
$sql = "SELECT * FROM usuarios WHERE id = $id";
$result = $conexion->query($sql);
if ($result->num_rows == 0) {
    echo "<script>alert('Usuario no encontrado'); window.location='logout.php';</script>";
    exit();
}
$usuario = $result->fetch_assoc();

// Actualizar datos
if (isset($_POST['guardar'])) {
    $nuevo_usuario = trim($_POST['usuario']);
    $nuevo_email   = trim($_POST['email']);
    $nueva_pass    = trim($_POST['password']);

    if (empty($nuevo_usuario) || empty($nuevo_email) || empty($nueva_pass)) {
        echo "<script>alert('⚠️ Todos los campos son obligatorios');</script>";
    } else {
        $password_encriptada = md5($nueva_pass);

        $update = "UPDATE usuarios 
                   SET usuario='$nuevo_usuario', email='$nuevo_email', password='$password_encriptada' 
                   WHERE id=$id";

        if ($conexion->query($update)) {
            // Actualizar sesión
            $_SESSION['usuario']['usuario'] = $nuevo_usuario;
            $_SESSION['usuario']['email'] = $nuevo_email;
            echo "<script>alert('✅ Datos actualizados con éxito'); window.location='perfil.php';</script>";
            exit();
        } else {
            echo "Error: " . $conexion->error;
        }
    }
}

// Eliminar cuenta
if (isset($_POST['eliminar'])) {
    $delete = "DELETE FROM usuarios WHERE id=$id";
    if ($conexion->query($delete)) {
        session_destroy();
        echo "<script>alert('🗑️ Usuario eliminado correctamente'); window.location='login.php';</script>";
        exit();
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>

<body>
    <header>
        <h1><img src="img/logo.png" alt="Logo"> Sistema de Estudiantes</h1>
        <a href="logout.php" class="btn-logout">🚪 Cerrar Sesión</a>
    </header>

    <main>
        <div class="card">
            <h1>👤 Perfil de Usuario</h1>
            <a href="./index.php" class="btn btn-volver">⬅ Volver</a>
            <form method="POST">
                <input type="text" name="usuario" value="<?php echo $usuario['usuario']; ?>" required><br>
                <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>
                <input type="password" name="password" placeholder="Nueva contraseña" required><br>

                <button type="submit" name="guardar" class="btn btn-guardar">💾 Guardar Cambios</button>
                <button type="submit" name="eliminar" class="btn btn-eliminar"
                    onclick="return confirm('⚠️ ¿Seguro que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                    🗑️ Eliminar Usuario
                </button>
            </form>
        </div>
    </main>
</body>

</html>
