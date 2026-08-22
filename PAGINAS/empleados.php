<?php
include '../PHP/conexion.php';

// Consulta todos los empleados
$result = $conexion->query("SELECT * FROM empleados");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Empleados</title>
  <link rel="stylesheet" href="../CSS/EMPLEADOSS.CSS">
</head>
<body>
  <h1>Empleados</h1>

  <div class="add-button">
    <a href="../PHP/agregar_empleado.php" class="btn-agregar">Agregar Empleado</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Cargo</th>
        <th>Salario</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if($result->num_rows > 0): ?>
        <?php while ($fila = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['cargo']) ?></td>
            <td>$<?= number_format($fila['salario'], 2) ?></td>
            <td>
              <a class="edit" href="../PHP/editar_empleado.php?id=<?= $fila['id'] ?>">Editar</a>
              <a class="delete" href="../PHP/eliminar_empleado.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar este empleado?')">Eliminar</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">No hay empleados registrados</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
