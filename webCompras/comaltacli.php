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
    <title>Alta de Clientes</title>
</head>
<body>
    <h2>Alta de Clientes</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="nif">Nif: </label>
        <input type="text" id="nif" name="nif"><br><br>
        <label for="nombre">Nombre: </label>
        <input type="text" id="nombre" name="nombre"><br><br>
        <label for="apellido">Apellido: </label>
        <input type="text" id="apellido" name="apellido"><br><br>
        <label for="cp">CP: </label>
        <input type="text" id="cp" name="cp"><br><br>
        <label for="dir">Dirección: </label>
        <input type="text" id="dir" name="dir"><br><br>
        <label for="ciudad">Ciudad: </label>
        <input type="text" id="ciudad" name="ciudad"><br><br>
        <button type="submit">Dar de Alta</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nif = test_input($_POST["nif"]);
            $nombre = test_input($_POST["nombre"]);
            $apellido = test_input($_POST["apellido"]);
            $cp = test_input($_POST["cp"]);
            $dir = test_input($_POST["dir"]);
            $ciudad = test_input($_POST["ciudad"]);
            
            if (empty($nif) || empty($nombre) || empty($apellido) || empty($cp) || empty($dir) || empty($ciudad)) {
                trigger_error("Todos los campos son obligatorios.", E_USER_ERROR);
            }

            $validoNif = validarNif($nif);
            $existe = clienteExiste($nif);

            if ($validoNif && !$existe) {
                altaCliente($nif, $nombre, $apellido, $cp, $dir, $ciudad);
            }
            
        }
    ?>
</body>
</html>