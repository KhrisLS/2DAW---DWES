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
    <title>Aprovisionar Productos</title>
</head>
<body>
    <h2>Aprovisionar Productos</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="num_almacen">Almacén: </label>
        <select name="num_almacen" id="num_almacen">
            <?php
                listaAlmacenes();
            ?>
        </select><br><br>
        <label for="id_producto">Producto: </label>
        <select name="id_producto" id="id_producto">
            <?php
                listaProductos();
            ?>
        </select><br><br>
        <label for="cantidad">Cantidad: </label>
        <input type="text" id="cantidad" name="cantidad"><br><br>
        <button type="submit">Agregar Stock</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $num_almacen = test_input($_POST["num_almacen"]);
            $id_producto = test_input($_POST["id_producto"]);
            $cantidad = test_input($_POST["cantidad"]);
            
            if (empty($num_almacen) || empty($id_producto) || empty($cantidad)) {
                trigger_error("Todos los campos son obligatorios.", E_USER_ERROR);
            }
            
            asignarStock($num_almacen, $id_producto, $cantidad);
        }
    ?>
</body>
</html>