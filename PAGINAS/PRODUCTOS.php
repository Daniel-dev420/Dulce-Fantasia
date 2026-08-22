<?php

session_start();

include("../PHP/conexion.php");

// =========================================================
// INICIALIZAR CARRITO
// =========================================================

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}


// =========================================================
// AGREGAR PRODUCTO AL CARRITO
// =========================================================

if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST['id'], $_POST['nombre'], $_POST['precio'])
) {

    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);

    $en_carrito = false;

    foreach ($_SESSION['carrito'] as &$item) {

        if ($item['id'] === $id) {

            $item['cantidad']++;

            $en_carrito = true;

            break;
        }
    }

    unset($item);

    if (!$en_carrito) {

        $_SESSION['carrito'][] = [
            "id" => $id,
            "nombre" => $nombre,
            "precio" => $precio,
            "cantidad" => 1
        ];
    }

    header("Location: PRODUCTOS.php");

    exit;
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tienda Virtual - Dulce Fantasía</title>

    <link
        rel="stylesheet"
        href="../CSS/PRODUCTOS.CSS"
    >

</head>


<body>


<header>

    <nav>

        <div class="logo">

            <img
                src="../IMAGENES/logo-modified-removebg-preview-removebg-preview.png"
                alt="Logo Dulce Fantasía"
            >

            <span class="nombre">
                Dulce Fantasía
            </span>

        </div>


        <div class="nav-right">

            <div class="nav-links">

                <a href="../index.html">
                    Inicio
                </a>

                <a href="../PAGINAS/NUESTRA EMPRESA.html">
                    Nuestra Empresa
                </a>

                <a href="../PAGINAS/PRODUCTOS.php">
                    Productos
                </a>

                <a href="../PAGINAS/CONTACTENOS.html">
                    Contáctenos
                </a>

                <a href="../PAGINAS/INICIO DE SESION.php">
                    Inicio de Sesión
                </a>

                <a href="../PAGINAS/SERVICIOS.HTML">
                    Servicios
                </a>

                <a href="../PAGINAS/REGISTRARSE.php">
                    Registrarse
                </a>

            </div>


            <div class="social-links">

                <a
                    href="https://www.facebook.com/profile.php?id=61568157712218&mibextid=ZbWKwL"
                    target="_blank"
                >

                    <img
                        src="../IMAGENES/FACEBOOK.png"
                        alt="Facebook"
                        class="icon"
                    >

                </a>


                <a
                    href="https://www.instagram.com/dulcefantasia134/"
                    target="_blank"
                >

                    <img
                        src="../IMAGENES/instagram.jpg"
                        alt="Instagram"
                        class="icon"
                    >

                </a>


                <a
                    href="https://wa.me/573219740048"
                    target="_blank"
                >

                    <img
                        src="../IMAGENES/whatsapp.png"
                        alt="WhatsApp"
                        class="icon"
                    >

                </a>

            </div>

        </div>

    </nav>

</header>


<main>

    <h2>
        Nuestros Productos
    </h2>


    <div class="productos">

        <?php

        // =====================================================
        // CONSULTAR PRODUCTOS
        // =====================================================

        $resultado = $conexion->query(
            "SELECT id, nombre, precio, imagen FROM productos"
        );


        if ($resultado && $resultado->num_rows > 0):

            while ($fila = $resultado->fetch_assoc()):

        ?>

            <div class="producto">


                <?php if (!empty($fila['imagen'])): ?>

                    <!--
                        Las imágenes están en:

                        REPOSTERIA/PHP/uploads/

                        La base de datos guarda:

                        uploads/nombre-imagen.jpeg

                        Como PRODUCTOS.php está en PAGINAS/,
                        necesitamos ../PHP/
                    -->

                    <img
                        src="../PHP/<?= htmlspecialchars(
                            $fila['imagen'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        alt="<?= htmlspecialchars(
                            $fila['nombre'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                <?php endif; ?>


                <h3>

                    <?= htmlspecialchars(
                        $fila['nombre'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </h3>


                <p>

                    $<?= number_format(
                        $fila['precio'],
                        0,
                        ',',
                        '.'
                    ) ?>

                </p>


                <form
                    method="POST"
                    action="PRODUCTOS.php"
                >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $fila['id'] ?>"
                    >


                    <input
                        type="hidden"
                        name="nombre"
                        value="<?= htmlspecialchars(
                            $fila['nombre'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >


                    <input
                        type="hidden"
                        name="precio"
                        value="<?= $fila['precio'] ?>"
                    >


                    <button type="submit">
                        Agregar al carrito
                    </button>

                </form>


            </div>


        <?php

            endwhile;

        else:

        ?>

            <p>
                No hay productos disponibles.
            </p>

        <?php endif; ?>

    </div>


    <!-- =====================================================
         CARRITO
    ====================================================== -->

    <section class="carrito">

        <h2>
            🛒 Carrito de Compras
        </h2>


        <?php if (!empty($_SESSION['carrito'])): ?>

            <ul>

                <?php

                $total = 0;

                foreach ($_SESSION['carrito'] as $item):

                    $subtotal =
                        $item['precio'] *
                        $item['cantidad'];

                    $total += $subtotal;

                ?>

                    <li>

                        <?= htmlspecialchars(
                            $item['nombre'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                        -

                        $<?= number_format(
                            $item['precio'],
                            0,
                            ',',
                            '.'
                        ) ?>

                        (x<?= $item['cantidad'] ?>)

                    </li>

                <?php endforeach; ?>

            </ul>


            <p>

                <strong>
                    Total:
                </strong>

                $<?= number_format(
                    $total,
                    0,
                    ',',
                    '.'
                ) ?>

            </p>


            <a
                href="pago.php"
                class="btn"
            >
                Finalizar Compra
            </a>


        <?php else: ?>

            <p>
                Tu carrito está vacío.
            </p>

        <?php endif; ?>


    </section>

</main>


<footer>

    <p>
        &copy; 2025 Dulce Fantasía
    </p>

</footer>


</body>

</html>
