<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/db.php");

// Validar si llega el ID
if (!isset($_GET['id'])) {
    header("Location: ../index.php");
    exit();
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM estudiantes WHERE id = $id";
$result = $conexion->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('Estudiante no encontrado'); window.location='../index.php';</script>";
    exit();
}

$estudiante = $result->fetch_assoc();

// Traer cursos
$cursos = $conexion->query("SELECT * FROM cursos");

// Procesar actualización
if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $curso_id = $_POST['curso_id'];

    // Verificar si hubo cambios
    if (
        $nombre == $estudiante['nombre'] &&
        $email == $estudiante['email'] &&
        $curso_id == $estudiante['curso_id']
    ) {

        echo "<script>alert('⚠️ No se han modificado los datos');</script>";
    } else {
        $update = "UPDATE estudiantes 
                   SET nombre='$nombre', email='$email', curso_id='$curso_id' 
                   WHERE id=$id";
        if ($conexion->query($update)) {
            echo "<script>alert('✅ Estudiante actualizado con éxito'); window.location='../index.php';</script>";
            exit();
        } else {
            echo "Error: " . $conexion->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" href="../css/edit.css">
</head>

<body>
    <header>
        <h1><img src="../img/logo.png" alt="Logo"> Sistema de Estudiantes</h1>
        <a href="logout.php" class="btn-logout">🚪 Cerrar Sesión</a>
    </header>
    <main>
        <div class="card">
            <h1>✏️ Editar Estudiante</h1>
            <form method="POST">
                <input type="text" name="nombre" value="<?php echo $estudiante['nombre']; ?>" required><br>
                <input type="email" name="email" value="<?php echo $estudiante['email']; ?>" required><br>
                <select name="curso_id" required>
                    <?php while ($curso = $cursos->fetch_assoc()) { ?>
                        <option value="<?php echo $curso['id']; ?>"
                            <?php if ($curso['id'] == $estudiante['curso_id']) echo 'selected'; ?>>
                            <?php echo $curso['nombre']; ?>
                        </option>
                    <?php } ?>
                </select><br>

                <button type="submit" name="guardar" class="btn btn-guardar">💾 Guardar</button>
                <a href="../index.php" class="btn btn-volver">⬅ Volver</a>
            </form>
        </div>
    </main>
</body>

</html>