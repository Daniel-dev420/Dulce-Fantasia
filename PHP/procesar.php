<?php
include "conexion.php";

$nombre = $_POST['nombre'];
$cargo = $_POST['cargo'];
$salario = $_POST['salario'];

$sql = "INSERT INTO empleados (nombre, cargo, salario) VALUES ('$nombre', '$cargo', '$salario')";
$conexion->query($sql);

header("Location: ../views/index.php");
?>
