<?php

require_once "conexion.php";


/* =========================================================
   RECIBIR DATOS
========================================================= */

$nombre   = trim($_POST['nombre'] ?? '');
$email    = trim($_POST['email'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$mensaje  = trim($_POST['mensaje'] ?? '');


/* =========================================================
   VALIDAR DATOS
========================================================= */

if (
    empty($nombre) ||
    empty($email) ||
    empty($telefono) ||
    empty($mensaje)
) {
    die("Todos los campos son obligatorios.");
}


/* =========================================================
   VALIDAR CORREO
========================================================= */

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("El correo electrónico no es válido.");
}


/* =========================================================
   INSERTAR MENSAJE
========================================================= */

$sql = "INSERT INTO contacto
        (nombre_completo, correo_electronico, telefono, mensaje)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}


$stmt->bind_param(
    "ssss",
    $nombre,
    $email,
    $telefono,
    $mensaje
);


/* =========================================================
   EJECUTAR
========================================================= */

if ($stmt->execute()) {

    echo "<script>
            alert('Mensaje enviado correctamente.');
            window.location.href='../paginas/contactenos.html';
          </script>";

} else {

    echo "Error al guardar el mensaje: " . $stmt->error;
}


/* =========================================================
   CERRAR
========================================================= */

$stmt->close();
$conexion->close();

?>