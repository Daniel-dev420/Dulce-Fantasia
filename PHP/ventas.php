<?php
include 'conexion.php';

// Consulta de ventas
$sql = "SELECT * FROM ventas ORDER BY fecha DESC";
$resultado = $conexion->query($sql);

// Validar consulta
if (!$resultado) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Ventas</title>
    <link rel="stylesheet" href="../CSS/VENTASS.CSS">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Matangi:wght@300..900&family=Michroma&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <h1>Historial de Ventas</h1>

</header>

<main>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Monto ($)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado->num_rows > 0): ?>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['fecha'] ?></td>
                        <td><?= htmlspecialchars($row['cliente']) ?></td>
                        <td>$<?= number_format($row['monto'], 2, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay registros de ventas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
    <div class="botones-principales">
        <a href="../PHP/exportar_ventas.php" class="boton" target="_blank">Exportar a PDF</a>
        <a href="../PHP/pag_admin.php" class="boton">Volver al Panel</a>
    </div>
</body>
</html>
