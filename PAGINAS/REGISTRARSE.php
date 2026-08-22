<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrarse - Dulce Fantasía</title>
  <link rel="stylesheet" href="../CSS/REGISTRARSE.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Matangi:wght@300..900&family=Michroma&display=swap" rel="stylesheet">
</head>

<body>
  <div id="contenedor">
    <div id="contenido">
      <h1>Regístrate en <span class="marca">Dulce Fantasía</span></h1>

      <!-- El formulario manda los datos a procesar_registro.php -->
      <form action="../PHP/procesar_registro.php" method="POST" class="form-registro">

        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ej: Ana Pérez" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required>

        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario" placeholder="Usuario123" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="********" required>

        <!-- Checkbox de términos -->
        <div class="terminos">
          <label>
            <input type="checkbox" name="terminos" required>
            Acepto los <a href="../PAGINAS/terminos.html" target="_blank">Términos y Condiciones</a>
          </label>
        </div>

        <!-- Botones -->
        <div class="acciones">
          <button type="submit" class="btn-registrar">Registrarse</button>
          <button type="reset" class="btn-reset">Borrar</button>
        </div>

        <!-- Volver -->
        <div class="volver">
          <a href="../index.html" class="btn-volver">Volver al inicio</a>
        </div>

      </form>
    </div>
  </div>
</body>
</html>
