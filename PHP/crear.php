<?php
include '../PHP/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoria  = $_POST['categoria']; // Corregido: antes 'categoria'
    
    $nombreImagen = $_FILES['imagen']['name'];
    $rutaTemporal = $_FILES['imagen']['tmp_name'];
    $carpetaDestino = "uploads/" . $nombreImagen;

    if (move_uploaded_file($rutaTemporal, $carpetaDestino)) {
        // Corregido: ahora usa 'tipo'
        $query = "INSERT INTO productos (nombre, precio, imagen, categoria)
                  VALUES ('$nombre', '$precio', '$carpetaDestino', '$categoria')";
        if ($conexion->query($query)) {
            header("Location: ../PHP/pag_admin.php");
            exit;
        } else {
            echo "Error: " . $conexion->error;
        }
    } else {
        echo "Error al subir la imagen.";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="number" step="0.01" name="precio" placeholder="Precio" required>
    <input type="text" name="categoria" placeholder="Categoría" required>
    <input type="file" name="imagen" required>
    <button type="submit">Guardar Producto</button>
</form>
