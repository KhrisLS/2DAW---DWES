<?php
include "conexion.php";
include "funciones.php";
include "errores.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario"><br><br>
        <label for="clave">Clave:</label>
        <input type="password" id="clave" name="clave"><br><br>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = test_input($_POST["usuario"]);
            $clave = test_input($_POST["clave"]);

            if (empty($usuario) || empty($clave)) {
                trigger_error("Todos los campos son obligatorios.", E_USER_ERROR);
            }
            
            verificarLogin($usuario, $clave);
        }
    ?>
</body>
</html>