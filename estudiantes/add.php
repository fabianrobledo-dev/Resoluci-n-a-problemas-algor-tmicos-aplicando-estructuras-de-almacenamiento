<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

require_once("../config/db.php");

// Traer cursos
$cursos = $conexion->query("SELECT * FROM cursos");

// Procesar inserción
if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $curso_id = $_POST['curso_id'];

    // Validar si el correo ya existe
    $check = $conexion->query("SELECT * FROM estudiantes WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "<script>alert('⚠️ El correo ya está registrado');</script>";
    } else {
        $sql = "INSERT INTO estudiantes (nombre, email, curso_id) VALUES ('$nombre', '$email', '$curso_id')";
        if ($conexion->query($sql)) {
            echo "<script>alert('✅ Estudiante agregado correctamente'); window.location='../index.php';</script>";
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
    <title>Agregar Estudiante</title>
    <link rel="stylesheet" href="../css/add.css">
</head>
<body>
    <div class="add-container">
        <div class="card">
            <div class="logo">
                <img src="../img/logo.png" alt="Logo">
            </div>
            <h1>➕ Agregar Estudiante</h1>
            <form method="POST">
                <label>Nombre completo</label>
                <input type="text" name="nombre" placeholder="Nombre completo" required>

                <label>Correo electrónico</label>
                <input type="email" name="email" placeholder="Correo electrónico" required>

                <label>Curso</label>
                <select name="curso_id" required>
                    <option value="">Selecciona un curso</option>
                    <?php while ($curso = $cursos->fetch_assoc()) { ?>
                        <option value="<?php echo $curso['id']; ?>"><?php echo $curso['nombre']; ?></option>
                    <?php } ?>
                </select>

                <button type="submit" name="guardar" class="btn btn-guardar">💾 Guardar</button>
                <a href="../index.php" class="btn btn-volver">⬅ Volver</a>
            </form>
        </div>
    </div>
</body>
</html>
