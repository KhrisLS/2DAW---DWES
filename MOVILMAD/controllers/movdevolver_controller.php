<?php
    require_once ("models/movdevolver_model.php");
    require_once ("controllers/funciones_controller.php");
    require_once("views/movdevolver.php");
    require_once("apiRedsys.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $matricula = $_POST['matricula'];
        $matricula = test_input($matricula);

        $cliente = $_SESSION['usuario']['idcliente'];
        $confirmacion = false;

        if (isset($_POST['devolver'])){
            
            $precioTotal = calcularPrecioTotal($matricula);
            var_dump($precioTotal);
            $fechaDevolucion = calcularFechaDevolucion();
            var_dump($fechaDevolucion);

            crearCookiePago($matricula, $precioTotal, $fechaDevolucion);
            pasarelaPago($precioTotal);
        }

        if (isset($_POST['volver'])){
            header("Location: welcome.php");
            exit();
        }
        
    }

    //============================================== FUNCIONES =================================================
    function listaVehiculosAlquilados(){
        $cliente = $_SESSION['usuario']['idcliente'];
        $vehiculos = vehiculosAlquilados($cliente);

        // Opción por defecto
        echo "<option value=''>-- SELECCIONA UNA OPCIÓN --</option>";

        // Usamos los datos obtenidos
        foreach ($vehiculos as $row) {
            echo "<option value='" . $row["matricula"] . "'>" . $row['matricula'] . " - " . $row["marca"] . " - " . $row["modelo"]. "</option>";
        }
    }

    function calcularPrecioTotal($matricula){
        $resultadoPrecioBase = consultarPrecioBase($matricula);
        $precioBase = $resultadoPrecioBase[0]['preciobase'];
        var_dump($precioBase);

        $resultadoTiempo = calcularTiempoAlquilado($matricula);
        $tiempoAlquilado = $resultadoTiempo[0]['diferencia_minutos'];
        var_dump($tiempoAlquilado);

        $precioTotal = calcularPrecio($precioBase, $tiempoAlquilado);

       return $precioTotal;
    }

    function calcularPrecio($precioBase, $tiempoAlquilado) {
        if ($tiempoAlquilado < 1){
            $tiempoAlquilado = 1;
        }

        $resultado = $precioBase *  $tiempoAlquilado;
        
        return $resultado;
    }

    function crearCookiePago($matricula, $precioTotal, $fechaDevolucion){
        $nombreCookie = 'pago';
        
        if (isset($_COOKIE[$nombreCookie])) {
            $pago = unserialize($_COOKIE[$nombreCookie]);
            if (!is_array($pago)) {
                $pago = array();
            }
        } else {
            $pago = array();
        }

        $pago = [
            'matricula' => $matricula,
            'precioTotal' => $precioTotal,
            'fechaDevolucion' => $fechaDevolucion
        ];

        $pagoSerializado = serialize($pago);

        setcookie($nombreCookie, $pagoSerializado, time() + (60 * 60), "/");
    }

    function calcularFechaDevolucion() {
        date_default_timezone_set('Europe/Madrid');
        return date('Y-m-d H:i:s');
    }

    function pasarelaPago($precioTotal){
            
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
        $urlOk = 'http://192.168.206.227/MOVILMAD/pagoOk.php'; // Pago exitoso
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

?>