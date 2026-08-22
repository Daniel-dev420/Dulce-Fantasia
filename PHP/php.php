<?php

require_once "conexion.php";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Solicitud no válida."
    ]);
    exit;
}

$Nombre   = trim($_POST['Nombre'] ?? '');
$Email    = trim($_POST['Email'] ?? '');
$Telefono = trim($_POST['Telefono'] ?? '');
$Mensaje  = trim($_POST['Mensaje'] ?? '');

if (
    $Nombre === '' ||
    $Email === '' ||
    $Telefono === '' ||
    $Mensaje === ''
) {
    echo json_encode([
        "success" => false,
        "message" => "Todos los campos son obligatorios."
    ]);
    exit;
}

$sql = "INSERT INTO contacto (nombre, email, telefono, mensaje)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Error al preparar la consulta."
    ]);
    exit;
}

$stmt->bind_param(
    "ssss",
    $Nombre,
    $Email,
    $Telefono,
    $Mensaje
);

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "¡Mensaje enviado correctamente! ✅"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "No se pudo enviar el mensaje."
    ]);
}

$stmt->close();
$conexion->close();

?>