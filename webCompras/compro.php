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
    <title>Compra de Productos</title>
</head>
<body>
    <h2>Compra de Productos</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="nif">Nif: </label>
        <input type="text" id="nif" name="nif"><br><br>
        <label for="id_producto">Producto: </label>
        <select name="id_producto" id="id_producto">
            <?php
                listaProductos();
            ?>
        </select><br><br>
        <label for="cantidad">Cantidad: </label>
        <input type="text" id="cantidad" name="cantidad"><br><br>
        <button type="submit">Realizar Compra</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nif = test_input($_POST["nif"]);
            $id_producto = test_input($_POST["id_producto"]);
            $cantidad = test_input($_POST["cantidad"]);
            
            if (empty($nif) || empty($id_producto) || empty($cantidad)) {
                trigger_error("No se ha seleccionado un producto.", E_USER_ERROR);
            }
            
            $valido = disponibilidadStock($id_producto, $cantidad);

            if ($valido) {
                realizarCompra($nif, $id_producto, $cantidad);
                actualizarStock($id_producto, $cantidad);
            }
        }
    ?>
</body>
</html>