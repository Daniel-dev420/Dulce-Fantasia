<?php
include 'conexion.php';

$cliente = $_POST['cliente'];
$monto = $_POST['monto'];
$fecha = date('Y-m-d');

$sql = "INSERT INTO ventas ( fecha, cliente, monto) VALUES ('$fecha', '$cliente', $monto)";
if ($conexion->query($sql) === TRUE) {
  header("Location: ventas.php");
} else {
  echo "Error: " . $conexion->error;
}
?>