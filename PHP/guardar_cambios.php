<?php
include "conexion.php";

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$cargo = $_POST['cargo'];
$salario = $_POST['salario'];

$sql = "UPDATE empleados SET nombre='$nombre', cargo='$cargo', salario='$salario' WHERE id=$id";
$conexion->query($sql);

header("Location: ../views/index.php");
?>
