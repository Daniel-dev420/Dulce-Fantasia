<?php
session_start();
include('../PHP/conexion.php');

$usu  = $_POST["txtusuario"] ?? '';
$pass = $_POST["txtpassword"] ?? '';

if ($usu === '' || $pass === '') {
    echo "<script>
            alert('Por favor completa usuario y contraseña.');
            window.location= '../PAGINAS/INICIO DE SESION.php';
          </script>";
    exit;
}

$query = $conexion->prepare("SELECT * FROM login WHERE usuario = ?");
$query->bind_param("s", $usu);
$query->execute();
$resultado = $query->get_result();

if ($resultado->num_rows == 1) {
    $fila = $resultado->fetch_assoc();

    // Verificar contraseña con hash
    if (password_verify($pass, $fila['pass'])) {
        $_SESSION['user_id'] = $fila['id'];
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['rol']     = $fila['rol'];

        if ($fila['rol'] == "Usuario") {
            header("Location: ../PAGINAS/PRODUCTOS.php");
            exit;
        } elseif ($fila['rol'] == "Admin") {
            header("Location: ../PHP/pag_admin.php");
            exit;
        } else {
            echo "<script>
                    alert('Rol inválido.');
                    window.location= '../PAGINAS/INICIO DE SESION.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Contraseña incorrecta.');
                window.location= '../PAGINAS/INICIO DE SESION.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Usuario no encontrado.');
            window.location= '../PAGINAS/INICIO DE SESION.php';
          </script>";
}

$query->close();
$conexion->close();
?>
