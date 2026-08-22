<?php
include 'conexion.php';

if (!isset($_GET['id'])) die("Error: ID no recibido.");
$id = intval($_GET['id']);

$stmt = $conexion->prepare("DELETE FROM empleados WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../PAGINAS/empleados.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
