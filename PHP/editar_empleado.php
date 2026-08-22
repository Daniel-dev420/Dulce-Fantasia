<?php
include 'conexion.php';

if (!isset($_GET['id'])) die("Error: ID no recibido.");
$id = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $salario = floatval($_POST['salario']);

    $stmt = $conexion->prepare("UPDATE empleados SET nombre=?, cargo=?, salario=? WHERE id=?");
    $stmt->bind_param("ssdi", $nombre, $cargo, $salario, $id);
    if ($stmt->execute()) {
        header("Location: ../PAGINAS/empleados.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

$res = $conexion->query("SELECT * FROM empleados WHERE id=$id");
$empleado = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Empleado</title>
</head>
<body>
  <h1>Editar Empleado</h1>
  <form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($empleado['nombre']) ?>" required><br><br>

    <label>Cargo:</label><br>
    <input type="text" name="cargo" value="<?= htmlspecialchars($empleado['cargo']) ?>" required><br><br>

    <label>Salario:</label><br>
    <input type="number" step="0.01" name="salario" value="<?= $empleado['salario'] ?>" required><br><br>

    <button type="submit">Guardar</button>
    <a href="../PAGINAS/empleados.php">Cancelar</a>
  </form>
</body>
</html>
