<?php include '../PHP/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Productos</title>
    <link rel="stylesheet" href="../CSS/admin.CSS">

</head>

<body>
    <h1>Productos registrados</h1>
    <a href="../PHP/crear.php" class="btn">Agregar nuevo producto</a>
    <a href="../PHP/exportar_productos.php" class="boton" target="_blank">Exportar a PDF</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Selecciona desde la tabla productos
            $resultado = $conexion->query("SELECT * FROM productos");
            while ($fila = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <!-- Corregido: el ID en tu tabla se llama 'id' -->
                    <td><?= $fila['id'] ?></td>
                    <td><?= $fila['nombre'] ?></td>
                    <td>$<?= number_format($fila['precio'], 0, ',', '.') ?></td>
                    <td><img src="<?= $fila['imagen'] ?>" alt="Imagen"></td>
                    <!-- Corregido: la categoría en tu tabla se llama 'tipo' -->
                    <td><?= $fila['categoria'] ?></td>
                    <td class="acciones">
                        <a href="../PHP/actualizar.php?id=<?= $fila['id'] ?>" class="editar">Editar</a>
                        <a href="../PHP/eliminar.php?id=<?= $fila['id'] ?>" class="eliminar"
                           onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>



    <a href="../PHP/ventas.php" class="boton">Ventas</a>
    <a href="../PAGINAS/empleados.php" class="boton">empleados</a>
    <a href="../Fiscales/index.html" class="boton">Nomina</a>
    <br>
    <br>
        <a href="../index.html" class="boton">Volver</a>
</body>
</html>
