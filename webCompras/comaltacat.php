<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Categorías</title>
</head>
<body>
    <h2>Alta de Categorías</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="nombre">Nombre de la categoría: </label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <button type="submit">Agregar Categoría</button>
    </form>

    <?php
        include "conexion.php";
        include "funciones.php";
        include "errores.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = test_input($_POST["nombre"]);
            
            if (empty($nombre)) {
                trigger_error("No se ha rellenado el campo.", E_USER_ERROR);
            }

            $ultCategoria = buscarUltCategoria();
            $nuevaCat = generarCodCategoria($ultCategoria); 

            crearCategoria($nuevaCat, $nombre);
        }
    ?>
</body>
</html>