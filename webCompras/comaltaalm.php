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
    <title>Alta de Almacenes</title>
</head>
<body>
    <h2>Alta de Almacenes</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="localidad">Localidad del almacén: </label>
        <input type="text" id="localidad" name="localidad"><br><br>
        <button type="submit">Agregar Almacén</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $localidad = test_input($_POST["localidad"]);
            
            if (empty($localidad)) {
                trigger_error("No se ha rellenado el campo.", E_USER_ERROR);
            }

            $ultAlmacen = buscarUltAlmacen();
            $numAlmacen = generarCodAlmacen($ultAlmacen);
            
            crearAlmacen($numAlmacen, $localidad);
        }
    ?>
</body>
</html>