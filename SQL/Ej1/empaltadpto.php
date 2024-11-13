<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ej1</title>
</head>
<body>
    <p>DAR DE ALTA DEPARTAMENTO</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="nombre">Nombre del Departamento </label>
        <input type="text" name="nombre" id="nombre"><br><br>

        <button type="submit">Crear</button>
        <button type="reset">Borrar</button>
    </form>

    <?php
        include ("../conexion.php");
        include ("../errores.php");
        include ("../funciones.php");

        if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
            $nombre = test_input($_POST['nombre']);
            
            $dpto = buscarUltimoDpto();
            $cod_dpto = generarCodDpto($dpto); 

            crearDpto($cod_dpto, $nombre);
            
            
        }
    ?>

</body>
</html>