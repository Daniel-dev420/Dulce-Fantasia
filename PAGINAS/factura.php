<?php
session_start();
include("../PHP/conexion.php");

// Verificar que haya productos
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "No hay productos en el carrito.";
    exit;
}

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Debes iniciar sesión antes de realizar una compra.');
            window.location.href = 'INICIO DE SESION.php';
          </script>";
    exit;
}

// Verificar datos del formulario
if (
    !isset(
        $_POST['nombre'],
        $_POST['numero'],
        $_POST['direccion'],
        $_POST['metodo']
    )
) {
    echo "Faltan datos del cliente.";
    exit;
}

// Datos del cliente
$cliente_nombre = trim($_POST['nombre']);
$cliente_numero = trim($_POST['numero']);
$cliente_direccion = trim($_POST['direccion']);
$metodo_pago = trim($_POST['metodo']);

// ID REAL del usuario que inició sesión
$cliente_id = $_SESSION['user_id'];

// Calcular total
$total = 0;

foreach ($_SESSION['carrito'] as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

// Iniciar transacción
$conexion->begin_transaction();

try {

    // ==========================================
    // INSERTAR FACTURA
    // ==========================================

    $stmt = $conexion->prepare(
        "INSERT INTO facturas (cliente_id, total) VALUES (?, ?)"
    );

    $stmt->bind_param("id", $cliente_id, $total);
    $stmt->execute();

    $factura_id = $stmt->insert_id;

    $stmt->close();


    // ==========================================
    // INSERTAR DETALLE DE FACTURA
    // ==========================================

    foreach ($_SESSION['carrito'] as $producto) {

        $producto_id = intval($producto['id']);
        $cantidad = intval($producto['cantidad']);
        $subtotal = $producto['precio'] * $cantidad;

        $stmt = $conexion->prepare(
            "INSERT INTO factura_detalle
            (factura_id, producto_id, cantidad, subtotal)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iiid",
            $factura_id,
            $producto_id,
            $cantidad,
            $subtotal
        );

        $stmt->execute();
        $stmt->close();
    }


    // ==========================================
    // INSERTAR VENTA
    // ==========================================

    $stmt = $conexion->prepare(
        "INSERT INTO ventas (fecha, cliente, monto)
         VALUES (NOW(), ?, ?)"
    );

    $stmt->bind_param("sd", $cliente_nombre, $total);
    $stmt->execute();

    $stmt->close();


    // ==========================================
    // CONFIRMAR TODO
    // ==========================================

    $conexion->commit();

    // Vaciar carrito
    $_SESSION['carrito'] = [];

} catch (Exception $e) {

    // Si algo falla, deshacer todo
    $conexion->rollback();

    die("Error al procesar la compra: " . $e->getMessage());
}

$conexion->close();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <link rel="stylesheet" href="../CSS/FACTURA.CSS">
</head>

<body>

    <div class="factura-box">

        <h1>Factura de Compra</h1>

        <br>
        <br>

        <p>
            <strong>Factura N°:</strong>
            <?= htmlspecialchars($factura_id) ?>
        </p>

        <p>
            <strong>Cliente:</strong>
            <?= htmlspecialchars($cliente_nombre) ?>
        </p>

        <p>
            <strong>Número:</strong>
            <?= htmlspecialchars($cliente_numero) ?>
        </p>

        <p>
            <strong>Dirección:</strong>
            <?= htmlspecialchars($cliente_direccion) ?>
        </p>

        <p>
            <strong>Método de Pago:</strong>
            <?= htmlspecialchars($metodo_pago) ?>
        </p>

        <p>
            <strong>Total:</strong>
            $<?= number_format($total, 2, ',', '.') ?>
        </p>

    </div>

</body>

</html>