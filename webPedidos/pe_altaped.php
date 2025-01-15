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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Realizar Pedido</title>
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
        <h2>Realizar Pedido</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="productCode">Producto: </label>
            <select name="productCode" id="productCode">
                <?php
                    listaProductos();
                ?>
            </select><br><br>
            <label for="cantidad">Cantidad: </label>
            <input type="text" id="cantidad" name="cantidad"><br><br>
            <label for="checkNumber">Check Number: </label>
            <input type="text" id="checkNumber" name="checkNumber"><br><br>
            <button type="submit" name='action' value='anadir_cesta'>Añadir a la Cesta</button>
            <button type='submit' name='action' value='ver_cesta'>Ver Cesta</button>
            <button type='submit' name='action' value='vaciar_cesta'>Vaciar Cesta</button>
            <button type='submit' name='action' value='pagar_cesta'>Pagar Cesta</button>
        </form>
    </main>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productCode = test_input($_POST["productCode"]);
            $cantidad = test_input($_POST["cantidad"]);
            $checkNumber = test_input($_POST["checkNumber"]);
            $cliente = $_SESSION['usuario'];
            
            // Convertir el checkNumber a mayúsculas
            $checkNumber = strtoupper($checkNumber);
            $confirmacion = false;

            if (isset($_POST['action']) && $_POST['action'] === 'anadir_cesta'){
                
                if (empty($productCode) || empty($cantidad)) {
                    trigger_error("No se ha seleccionado un producto o especificado una cantidad.", E_USER_ERROR);
                }   
                
                crearCookieCesta($productCode, $cantidad);
            }

            if (isset($_POST['action']) && $_POST['action'] === 'ver_cesta'){
                mostrarCesta();
                $total = calcularTotalCesta();
                echo "<strong>Total: $total</strong>";
            }
            
            if (isset($_POST['action']) && $_POST['action'] === 'vaciar_cesta'){
                vaciarCesta();
            }
            
            if (isset($_POST['action']) && $_POST['action'] === 'pagar_cesta'){
                //AA99999
                if (strlen($checkNumber)===7){
                    // Verificar los dos primeros caracteres (deben ser letras)
                    $esLetras = ctype_alpha(substr($checkNumber, 0, 2));

                    // Verificar los cinco caracteres restantes (deben ser números)
                    $esNumeros = ctype_digit(substr($checkNumber, 2));

                    // Confirmar si cumple ambos criterios
                    $confirmacion = $esLetras && $esNumeros;
                }

                if ($confirmacion){
                    //Guardamos el checkNumber en una cookie
                    cookieCheckNumber($checkNumber);
                   
                    $cesta = obtenercesta();
                    if (empty($cesta)) {
                        trigger_error('No tienes productos en la cesta', E_USER_ERROR);
                    }
                    
                    $precioTotal = calcularTotalCesta(); 

                    // Datos de la transacción para Redsys
                    $orderId = rand(1000000, 9999999); // Genera un ID único para el pedido
                    $currency = '978'; // EUR (ISO 4217 code)
                    $amount = intval($precioTotal * 100); // Monto en céntimos
                    
                    // Datos de configuración de Redsys
                    $dsSignatureVersion = 'HMAC_SHA256_V1';
                    $merchantCode = '263100000'; // Código de comercio
                    $secretKey = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7'; // Clave secreta
                    //sq7HjrUOBfKmC576ILgskD5srU870gJ7
                    // redsys nombre:isa clave:Metal123456789Metal
                    $url = 'https://sis-t.redsys.es:25443/sis/realizarPago'; // URL de pago de Redsys
                    $urlOk = 'http://192.168.206.227/webPedidos/pagoOk.php'; // Pago exitoso
                    $urlKo = 'https://thumbs.dreamstime.com/b/emoticon-triste-18589362.jpg'; // Error de pago
                    
                    $redsysAPI = new RedsysAPI();

                    $redsysAPI->setParameter("DS_MERCHANT_AMOUNT",$amount);
                    $redsysAPI->setParameter("DS_MERCHANT_ORDER",$orderId);
                    $redsysAPI->setParameter("DS_MERCHANT_MERCHANTCODE",$merchantCode);
                    $redsysAPI->setParameter("DS_MERCHANT_CURRENCY",$currency);
                    $redsysAPI->setParameter("DS_MERCHANT_TRANSACTIONTYPE",'0');
                    $redsysAPI->setParameter("DS_MERCHANT_TERMINAL",'15');
                    $redsysAPI->setParameter("DS_MERCHANT_MERCHANTURL",$url);
                    $redsysAPI->setParameter("DS_MERCHANT_URLOK",$urlOk);
                    $redsysAPI->setParameter("DS_MERCHANT_URLKO",$urlKo);

                    $params = $redsysAPI->createMerchantParameters();
                    $signature = $redsysAPI->createMerchantSignature($secretKey);

                    echo "<form name='frm' action='$url' method='POST' id='paymentForm'>";
                    echo "<input type='hidden' name='Ds_SignatureVersion' value='$dsSignatureVersion'>";
                    echo "<input type='hidden' name='Ds_MerchantParameters' value='$params'>";
                    echo "<input type='hidden' name='Ds_Signature' value='$signature'>";
                    echo "</form>";
                    echo "<script type='text/javascript'>document.getElementById('paymentForm').submit();</script>";

                }
                else{
                    trigger_error("Check Number NO válido.", E_USER_ERROR);                
                }

            }  
        }
    ?>
</body>
</html>