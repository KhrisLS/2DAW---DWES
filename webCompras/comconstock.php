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
    <title>Consulta de Stock</title>
</head>
<body>
    <h2>Consulta de Stock</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="id_producto">Producto: </label>
        <select name="id_producto" id="id_producto">
            <?php
                listaProductos();
            ?>
        </select><br><br>
        <button type="submit">Visualizar Stock</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_producto = test_input($_POST["id_producto"]);
            
            if (empty($id_producto)) {
                trigger_error("No se ha seleccionado un producto.", E_USER_ERROR);
            }
            
            visualizarStock($id_producto);
        }
    ?>
</body>
</html>