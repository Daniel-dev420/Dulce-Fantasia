<?php
session_start();
include("../PHP/conexion.php");

if (empty($_SESSION['carrito'])) {
    echo "<script>alert('No hay productos en el carrito'); window.location='productos.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_cliente = $_POST['nombre'];  // nombre en la tarjeta
    $total = 0;

    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    // Insertar venta en la tabla ventas
    $stmt = $conexion->prepare("INSERT INTO ventas (fecha, cliente, monto) VALUES (NOW(), ?, ?)");
    $stmt->bind_param("sd", $nombre_cliente, $total);
    $stmt->execute();

    // Vaciar carrito
    $_SESSION['carrito'] = [];

    echo "<script>alert('Compra realizada con éxito. ¡Gracias por tu pedido!'); window.location='productos.php';</script>";
}
?>
