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
    <title>Consulta de Almacenes</title>
</head>
<body>
    <h2>Consulta de Almacenes</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="num_almacen">Almacén: </label>
        <select name="num_almacen" id="num_almacen">
            <?php
                listaAlmacenes();
            ?>
        </select><br><br>
        <button type="submit">Visualizar Almacenes</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num_almacen = test_input($_POST["num_almacen"]);
            
            if (empty($num_almacen)) {
                trigger_error("No se ha seleccionado una opción.", E_USER_ERROR);
            }
            
            visualizarAlmacenes($num_almacen);
        }
    ?>
</body>
</html>