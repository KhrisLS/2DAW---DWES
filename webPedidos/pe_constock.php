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
    <title>Consultar Stock Total</title>
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
        <h2>Consultar Stock Total</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="productCode">Línea de Producto: </label>
            <select name="productLine" id="productLine">
                <?php
                    seleccionarLineaProducto();
                ?>
            </select><br><br>
            <button type="submit">Ver Stock</button>
        </form>
    </main>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productLine = test_input($_POST["productLine"]);
            
            if (empty($productLine)) {
                trigger_error("No se ha seleccionado una línea de producto.", E_USER_ERROR);
            }
            
            visualizarLineaProducto($productLine);
            
        }
    ?>
</body>
</html>