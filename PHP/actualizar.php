<?php
// actualizar.php
// Actualiza un producto (id) en la tabla productos
// Requisitos:
// - existencia de ../PHP/conexion.php que define $conexion (mysqli)
// - carpeta ../uploads con permisos de escritura (si no existe el script la crea)

include '../PHP/conexion.php';

// 1) comprobar que haya id en la URL
if (!isset($_GET['id'])) {
    die("Error: no se recibió ID de producto.");
}
$id = intval($_GET['id']);

// 2) obtener producto (prepared statement)
$stmt = $conexion->prepare("SELECT id, nombre, precio, categoria, imagen FROM productos WHERE id = ?");
if (!$stmt) {
    die("Error en la consulta (prepare): " . $conexion->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows === 0) {
    die("Producto no encontrado.");
}

$fila = $res->fetch_assoc();
$stmt->close();

// 3) si se envió el formulario, procesar actualización
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // sanitizar entradas
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $categoria   = trim($_POST['categoria'] ?? '');
    $imagen = $fila['imagen']; // por defecto la misma imagen actual

    // manejar subida de imagen si hay archivo nuevo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['imagen']['tmp_name'];
            $origName = basename($_FILES['imagen']['name']);
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif','webp'];

            if (!in_array($ext, $allowed)) {
                echo "<script>alert('Tipo de archivo no permitido. Usa jpg, png, gif o webp.');</script>";
            } else {
                // asegurarse que exista carpeta uploads (ruta relativa a este archivo)
                $uploadsDir = __DIR__ . '/../uploads';
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0755, true);
                }
                $newFilename = uniqid('prod_') . '.' . $ext;
                $destFull = $uploadsDir . '/' . $newFilename;
                if (move_uploaded_file($tmpName, $destFull)) {
                    // guardamos la ruta relativa que usan el resto de scripts (sin ../)
                    $imagen = 'uploads/' . $newFilename;
                    // (opcional) borrar la imagen antigua si existía y estaba en uploads/
                    if (!empty($fila['imagen']) && strpos($fila['imagen'], 'uploads/') === 0) {
                        $old = __DIR__ . '/../' . $fila['imagen'];
                        if (file_exists($old)) @unlink($old);
                    }
                } else {
                    echo "<script>alert('Error al mover la imagen subida.');</script>";
                }
            }
        } else {
            echo "<script>alert('Error al subir la imagen (código: " . $_FILES['imagen']['error'] . ").');</script>";
        }
    }

    // 4) Update con prepared statement
    $upd = $conexion->prepare("UPDATE productos SET nombre = ?, precio = ?, categoria = ?, imagen = ? WHERE id = ?");
    if (!$upd) {
        die("Error prepare UPDATE: " . $conexion->error);
    }
    $upd->bind_param("sdssi", $nombre, $precio, $categoria, $imagen, $id);

    if ($upd->execute()) {
        // Exito: volver al admin
        header("Location: pag_admin.php");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
    $upd->close();
}
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Actualizar producto</title>
<link rel="stylesheet" href="../CSS/ADMIN.CSS">
</head>
<body>
  <h1>Actualizar producto</h1>

  <form method="POST" enctype="multipart/form-data">
    <label>Nombre</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($fila['nombre'], ENT_QUOTES) ?>" required><br><br>

    <label>Precio</label><br>
    <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($fila['precio'], ENT_QUOTES) ?>" required><br><br>

    <label>Categoría (tipo)</label><br>
    <input type="text" name="categoria" value="<?= htmlspecialchars($fila['categoria'], ENT_QUOTES) ?>" required><br><br>

    <label>Imagen actual</label><br>
    <?php if (!empty($fila['imagen'])): ?>
        <img src="../<?= htmlspecialchars($fila['imagen'], ENT_QUOTES) ?>" alt="Imagen" width="160"><br>
    <?php else: ?>
        <em>No hay imagen</em><br>
    <?php endif; ?>
    <br>
    <label>Subir nueva imagen (opcional)</label><br>
    <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.gif,.webp"><br><br>

    <button type="submit">Actualizar</button>
    <a href="pag_admin.php">Cancelar</a>
  </form>
</body>
</html>
