<?php
include '../PHP/conexion.php';

if (!isset($_GET['id'])) {
    die("Error: no se recibió ID de producto.");
}

$id = intval($_GET['id']);

// Corregido: ahora usa 'id'
$sql = "DELETE FROM productos WHERE id=$id";

if ($conexion->query($sql)) {
    header("Location: ../PHP/pag_admin.php");
    exit;
} else {
    echo "Error al eliminar: " . $conexion->error;
}
?>
