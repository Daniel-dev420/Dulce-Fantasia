<?php
session_start();

// Si no hay carrito, no dejamos pasar
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "Tu carrito está vacío.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Método de Pago</title>
  <link rel="stylesheet" href="../CSS/PAGO.CSS">
</head>
<body>


  <form class="form-pago" method="POST" action="factura.php">
    <h1>Finalizar Compra</h1>  
  <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Número de contacto:</label>
    <input type="text" name="numero" required>

    <label>Dirección de entrega:</label>
    <input type="text" name="direccion" required>

    <label>Método de pago:</label>
    <select name="metodo" required>
      <option value="Nequi">Nequi</option>
      <option value="Efectivo">Efectivo</option>
    </select>

    <button type="submit">Confirmar Pedido</button>
  </form>
<br>

  <p><a href="PRODUCTOS.php">Volver al carrito</a></p>
</body>
</html>
