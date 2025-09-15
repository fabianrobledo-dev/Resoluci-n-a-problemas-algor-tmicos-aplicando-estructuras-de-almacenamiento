<?php
require_once("../config/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexion->query("DELETE FROM estudiantes WHERE id=$id");
}

header("Location: ../index.php");
exit();
