<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once("config/db.php");

// Buscar estudiante
$busqueda = "";
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['busqueda'];
    $query = "SELECT e.id, e.nombre, e.email, c.nombre AS curso
              FROM estudiantes e
              LEFT JOIN cursos c ON e.curso_id = c.id
              WHERE e.nombre LIKE '%$busqueda%' OR c.nombre LIKE '%$busqueda%'
              ORDER BY e.id DESC";
} else {
    $query = "SELECT e.id, e.nombre, e.email, c.nombre AS curso
              FROM estudiantes e
              LEFT JOIN cursos c ON e.curso_id = c.id
              ORDER BY e.id DESC";
}

$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Estudiantes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1><img src="img/logo.png" alt="Logo"> Sistema de Estudiantes</h1>
        <a href="perfil.php" class="btn btn-perfil">👤 Mi Perfil</a>
        <a href="logout.php" class="btn-logout">🚪 Cerrar Sesión</a>
    </header>

    <main>
        <div class="card">
            <h2>📚 Gestión de Estudiantes</h2>

            <!-- Formulario de búsqueda -->
            <form method="POST">
                <input type="text" name="busqueda" placeholder="Buscar estudiante o curso" value="<?php echo $busqueda; ?>">
                <input type="submit" name="buscar" value="Buscar">
            </form>

            <!-- Botón agregar -->
            <div style="text-align:center; margin-bottom:15px;">
                <a href="estudiantes/add.php" class="btn btn-agregar">➕ Agregar Estudiante</a>
            </div>

            <!-- Tabla de estudiantes -->
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['curso']; ?></td>
                            <td>
                                <a href="estudiantes/edit.php?id=<?php echo $row['id']; ?>" class="btn btn-editar">✏️ Editar</a>
                                <a href="estudiantes/delete.php?id=<?php echo $row['id']; ?>" 
                                class="btn btn-eliminar" 
                                onclick="return confirm('¿Seguro que deseas eliminar este estudiante?');">🗑️ Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:red; font-weight:bold;">
                            ⚠️ No se encontraron resultados para "<em><?php echo $busqueda; ?></em>"
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>
</body>
</html>
