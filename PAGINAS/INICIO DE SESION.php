<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar Sesión</title>

    <link rel="stylesheet" href="../CSS/SESION.CSS">
</head>

<body>

    <div class="login-container">

        <div class="login-box">

            <h1 class="login-title">Iniciar sesión</h1>

            <form method="post" action="../PHP/login.php">

                <label class="login-label">Usuario</label>

                <input
                    type="text"
                    name="txtusuario"
                    required
                    class="login-input"
                >

                <label class="login-label">Contraseña</label>

                <input
                    type="password"
                    name="txtpassword"
                    id="txtpassword"
                    required
                    class="login-input"
                >

                <div class="login-checkbox">

                    <input
                        type="checkbox"
                        onclick="verpassword()"
                    >

                    Mostrar contraseña

                </div>

                <div class="login-buttons">

                    <input
                        type="submit"
                        value="Entrar"
                        class="btn-login"
                    >

                    <input
                        type="reset"
                        value="Cancelar"
                        class="btn-login cancel"
                    >

                    <a
                        href="../index.html"
                        class="btn-login volver"
                    >
                        Volver
                    </a>

                </div>

            </form>

        </div>

    </div>

    <script>
        function verpassword() {
            const password = document.getElementById("txtpassword");

            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }
    </script>

</body>

</html>