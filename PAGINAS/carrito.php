<?php
session_start();

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito
if (isset($_POST['id'], $_POST['nombre'], $_POST['precio'])) {
    $producto = [
        "id" => $_POST['id'],
        "nombre" => $_POST['nombre'],
        "precio" => $_POST['precio'],
        "cantidad" => 1
    ];
    $_SESSION['carrito'][] = $producto;
    echo json_encode(["status" => "ok", "mensaje" => "Producto agregado"]);
    exit;
}

// Eliminar producto
if (isset($_POST['eliminar'])) {
    unset($_SESSION['carrito'][$_POST['eliminar']]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); 
    echo json_encode(["status" => "ok", "mensaje" => "Producto eliminado"]);
    exit;
}

// Obtener carrito
if (isset($_GET['ver'])) {
    echo json_encode($_SESSION['carrito']);
    exit;
}
?>
