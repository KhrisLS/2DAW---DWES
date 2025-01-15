<?php
ob_start(); // Iniciar buffer de salida

// Asegúrate de que session_start() sea lo primero
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "conexion.php";
include "funciones.php";
include "logout.php";
include "apiRedsys.php";

// Verificar si el usuario tiene una sesión activa
if (!isset($_SESSION['usuario'])) {
    cerrarSesion();
    header("Location: pe_login.php"); // Redirigir al inicio de sesión
    exit(); // Detener ejecución del script
}

include "errores.php";

// Lógica para ejecutar al cargar la página
if (isset($_COOKIE['checkNumber'])) {
    $cliente = $_SESSION['usuario'];
    $checkNumber = $_COOKIE['checkNumber'];
    $precioTotal = calcularTotalCesta();

    //comprobamos que no existe el checkNumber introducido
    $existe = comprobarCheckNumber($cliente, $checkNumber);

    if (!$existe){
        almacenarPedido($cliente, $checkNumber, $precioTotal);
        guardarPago($cliente, $checkNumber, $precioTotal);
    }else{
        almacenarPedido($cliente, $checkNumber, $precioTotal);
        actualizarRegistroPayments($cliente, $checkNumber, $precioTotal);
    }

    // Borrar la cookie de checkNumber
    setcookie("checkNumber", "", time() - 3600, "/");

    $mensaje = "¡Gracias por su compra!";
} else {
    $mensaje = "No se encontró un Check Number válido.";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido</title>
    <style>
        body {
            background-color: #d35400;
            color: white;
            display: flex; 
            flex-direction: column; 
            justify-content: center;
            align-items: center; 
            height: 100vh; 
            margin: 0; 
            text-align: center;
        }

        button {
            margin-top: 5px; 
            padding: 10px 20px;
            font-size: 16px;
            background-color: #e67e22;
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ca6f1e; 
        }
    </style>
</head>
<body>
    <h1><?php echo $mensaje; ?></h1>
    <form action="pe_altaped.php" method="GET">
        <button type="submit">Volver a la Página</button>
    </form>
</body>
</html>