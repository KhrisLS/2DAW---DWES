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
    <title>Alta de Productos</title>
</head>
<body>
    <h2>Alta de Productos</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="nombre">Nombre del producto: </label>
        <input type="text" id="nombre" name="nombre"><br><br>
        <label for="precio">Precio: </label>
        <input type="text" id="precio" name="precio"><br><br>
        <label for="id_cat">Categoría: </label>
        <select name="id_cat" id="id_cat">
            <?php
                listaCategorias();
            ?>
        </select><br><br>
        <button type="submit">Agregar Producto</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = test_input($_POST["nombre"]);
            $precio = test_input($_POST["precio"]);
            $id_cat = test_input($_POST["id_cat"]);
            
            if (empty($nombre) || empty($precio) || empty($id_cat)) {
                trigger_error("Todos los campos son obligatorios.", E_USER_ERROR);
            }

            $ultProducto = buscarUltProducto();
            $id_producto = generarCodProducto($ultProducto);
            
            crearProducto($id_producto, $nombre, $precio, $id_cat);
        }
    ?>
</body>
</html>