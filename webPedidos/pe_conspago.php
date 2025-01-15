<?php
include "conexion.php";
include "funciones.php";
include "logout.php";

session_start();
// Verificar si el usuario tiene una sesión activa
if (!isset($_SESSION['usuario'])) {
    cerrarSesion();
    header("Location: pe_login.php"); // Redirigir al inicio de sesión
    exit(); // Detener ejecución del script
}

include "errores.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pagos Realizados</title>
</head>
<body>
    <div id="bienvenida">
        <p>Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
        <form action="logout.php" method="POST">
            <button type="submit" name="cerrarSesion" value="true">Cerrar Sesión</button>
        </form>
    </div>
    <header>
        <h1>Portal de Pedidos</h1>
    </header>
    <nav>
        <a href="pe_altaped.php">Realizar Pedidos</a>
        <a href="pe_consped.php">Consultar Pedidos</a>
        <a href="pe_consprodstock.php">Consultar Stock</a>
        <a href="pe_constock.php">Consultar Stock Total</a>
        <a href="pe_topprod.php">Unidades Totales</a>
        <a href="pe_conspago.php">Pagos Realizados</a> 
    </nav>
    <main>
        <h2>Pagos Realizados</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="customerNumber">Cliente: </label>
            <select name="customerNumber" id="customerNumber">
                <?php
                    listaUsuarios();
                ?>
            </select><br><br>
            <label>Rango de Búsqueda: </label><br><br>
            <label for="fechaInicio">Desde: </label>
            <input type="date" id="fechaInicio" name="fechaInicio">
            <label for="fechaFinal">Hasta: </label>
            <input type="date" id="fechaFinal" name="fechaFinal"><br><br>
            <button type="submit">Ver Pagos</button>
        </form>
    </main>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $customerNumber = test_input($_POST["customerNumber"]);
            $fechaInicio = test_input($_POST["fechaInicio"]);
            $fechaFinal = test_input($_POST["fechaFinal"]);
            
            if (empty($customerNumber)) {
                trigger_error("No has seleccionado un cliente.", E_USER_ERROR);
            }
            
            visualizarPagos($customerNumber, $fechaInicio, $fechaFinal);
    
        }
    ?>
</body>
</html>