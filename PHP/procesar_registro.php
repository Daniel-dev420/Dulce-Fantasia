<?php

require_once "../PHP/conexion.php";


/* =========================================================
   RECIBIR DATOS
========================================================= */

$nombre   = trim($_POST['nombre'] ?? '');
$email    = trim($_POST['email'] ?? '');
$usuario  = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';


/* =========================================================
   VALIDAR CAMPOS
========================================================= */

if (
    $nombre === '' ||
    $email === '' ||
    $usuario === '' ||
    $password === ''
) {
    echo "<script>
            alert('Todos los campos son obligatorios.');
            history.back();
          </script>";

    exit;
}


/* =========================================================
   VALIDAR CORREO
========================================================= */

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo "<script>
            alert('El correo electrónico no es válido.');
            history.back();
          </script>";

    exit;
}


/* =========================================================
   ENCRIPTAR CONTRASEÑA
========================================================= */

$password_hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);


/* =========================================================
   VERIFICAR USUARIO O EMAIL
========================================================= */

$verificar = $conexion->prepare(
    "SELECT id
     FROM login
     WHERE usuario = ? OR email = ?
     LIMIT 1"
);

if (!$verificar) {
    die("Error en la consulta: " . $conexion->error);
}

$verificar->bind_param(
    "ss",
    $usuario,
    $email
);

$verificar->execute();

$verificar->store_result();


if ($verificar->num_rows > 0) {

    echo "<script>
            alert('El nombre de usuario o correo ya está registrado.');
            history.back();
          </script>";

    $verificar->close();
    $conexion->close();

    exit;
}

$verificar->close();


/* =========================================================
   INSERTAR USUARIO
========================================================= */

$stmt = $conexion->prepare(
    "INSERT INTO login
    (nombre, email, usuario, pass, rol)
    VALUES (?, ?, ?, ?, 'Usuario')"
);

if (!$stmt) {
    die("Error al preparar el registro: " . $conexion->error);
}


$stmt->bind_param(
    "ssss",
    $nombre,
    $email,
    $usuario,
    $password_hash
);


/* =========================================================
   EJECUTAR
========================================================= */

if ($stmt->execute()) {

    echo "<script>
            alert('¡Registro exitoso! Ahora puedes iniciar sesión.');
            window.location.href='../PAGINAS/INICIO DE SESION.php';
          </script>";

} else {

    echo "Error al registrar: " . $stmt->error;
}


/* =========================================================
   CERRAR
========================================================= */

$stmt->close();
$conexion->close();

?>