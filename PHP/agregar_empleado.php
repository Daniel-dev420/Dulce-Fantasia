<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $salario = floatval($_POST['salario']);

    $stmt = $conexion->prepare("INSERT INTO empleados (nombre, cargo, salario) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nombre, $cargo, $salario);

    if ($stmt->execute()) {
        header("Location: ../PAGINAS/empleados.php");
        exit;
    } else {
        echo "Error al agregar empleado: " . $conexion->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Empleado</title>
</head>
<body>
  <h1>Agregar Nuevo Empleado</h1>
  <form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Cargo:</label><br>
    <input type="text" name="cargo" required><br><br>

    <label>Salario:</label><br>
    <input type="number" step="0.01" name="salario" required><br><br>

    <button type="submit">Agregar</button>
    <a href="../PAGINAS/empleados.php">Cancelar</a>
  </form>
</body>
</html>
