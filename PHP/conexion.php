<?php

$servername = getenv('DB_HOST');
$username   = getenv('DB_USER');
$password   = getenv('DB_PASSWORD');
$dbname     = getenv('DB_NAME');
$port       = (int) getenv('DB_PORT');

$conexion = mysqli_init();

mysqli_ssl_set(
    $conexion,
    NULL,
    NULL,
    NULL,
    NULL,
    NULL
);

$conexion->real_connect(
    $servername,
    $username,
    $password,
    $dbname,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

?>