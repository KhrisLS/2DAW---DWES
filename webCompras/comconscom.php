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
    <title>Consulta de Compras</title>
</head>
<body>
    <h2>Consulta de Compras</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <label for="nif">Cliente: </label>
        <select name="nif" id="nif">
            <?php
                listaClientes();
            ?>
        </select><br><br>
        <label>Rango de Búsqueda: </label><br><br>
        <label for="fechaInicio">Desde: </label>
        <input type="date" id="fechaInicio" name="fechaInicio">
        <label for="fechaFinal">Hasta: </label>
        <input type="date" id="fechaFinal" name="fechaFinal"><br><br>
        <button type="submit">Visualizar Compras</button>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nif = test_input($_POST["nif"]);
            $fechaInicio = test_input($_POST["fechaInicio"]);
            $fechaFinal = test_input($_POST["fechaFinal"]);
            
            if (empty($nif) || empty($fechaInicio) || empty($fechaFinal)) {
                trigger_error("Todos los campos son obligatorios.", E_USER_ERROR);
            }
            
            visualizarCompras($nif, $fechaInicio, $fechaFinal);
        }
    ?>
</body>
</html>