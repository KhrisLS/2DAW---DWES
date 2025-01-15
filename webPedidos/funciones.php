<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function verificarLogin($usuario, $clave) {
    // Nombre de la cookie basado en el nombre del usuario
    $errorLogin = "intentos_$usuario";

    // Comprobar si la cookie existe y si los intentos han superado el límite
    if (isset($_COOKIE[$errorLogin])) {
        // Dividimos el valor de la cookie en dos: intentos y tiempo del último intento
        $datos = explode('|', $_COOKIE[$errorLogin]);
        $intentos = (int)$datos[0]; // Número de intentos fallidos
        $tiempoUltimoIntento = (int)$datos[1]; // Tiempo cuando se hizo el último intento

        if ($intentos >= 3) {
            // Calculamos cuánto tiempo falta para que se pueda intentar de nuevo
            $tiempoRestante = 60 - (time() - $tiempoUltimoIntento);
            if ($tiempoRestante > 0) {
                trigger_error("Has alcanzado el número máximo de intentos. Inténtalo de nuevo en $tiempoRestante segundos.", E_USER_WARNING);
                return;
            }
        }
    }

    $sql = "SELECT * FROM customers WHERE customerNumber = :customerNumber";
    $valores = [':customerNumber' => $usuario];
    $result = conexionBD($sql, $valores);

    $cliente = $result->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $passwd = password_hash($cliente['contactLastName'], PASSWORD_BCRYPT);

        if (password_verify($clave, $passwd)){
            // Si hizo login correctamente, borramos la cookie
            setcookie($errorLogin, "", time() - 3600, "/");
            
            session_start();
            $_SESSION['usuario'] = $cliente['customerNumber'];
        
            header("Location: pe_inicio.php"); // Redirige al portal de pedidos
            exit;
        } else {
            // Incrementar el contador de intentos
            if (isset($_COOKIE[$errorLogin])) {
                // Si existe la cookie para este usuario incrementamos los intentos
                $datos = explode('|', $_COOKIE[$errorLogin]);
                $intentos = (int)$datos[0] + 1;
            } else {
                // Si no existe la cookie le asignamos el primer intento
                $intentos = 1;
            }
            // Guardamos el tiempo actual como el momento del último intento
            $tiempoUltimoIntento = time();

            // Establecer la cookie con los valores de intentos y tiempo
            setcookie($errorLogin, "$intentos|$tiempoUltimoIntento", time() + 60, "/");
            
            trigger_error("Usuario o clave incorrectos.", E_USER_ERROR);
        }
    } else {
        // Incrementar el contador de intentos
        if (isset($_COOKIE[$errorLogin])) {
            $datos = explode('|', $_COOKIE[$errorLogin]);
            $intentos = (int)$datos[0] + 1;
        } else {
            $intentos = 1;
        }
        $tiempoUltimoIntento = time();

        setcookie($errorLogin, "$intentos|$tiempoUltimoIntento", time() + 60, "/");
        
        trigger_error("Usuario no encontrado.", E_USER_ERROR);
    } 
}

function listaProductos(){    
    $sql = "SELECT productCode, productName, quantityInStock  FROM products";
    $result = conexionBD($sql);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Opción por defecto
    echo "<option value=''>-- NO ASIGNADO --</option>";

    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        if ($row['quantityInStock'] > 0) {
            echo "<option value='" . $row["productCode"] . "'>" . $row["productName"] . "</option>";
        }
    }
}

function visualizarStock($productCode){
    $sql = "SELECT productCode, productName, quantityInStock 
            FROM products 
            WHERE productCode = :productCode";
    $valores = [':productCode' => $productCode];
    $result = conexionBD($sql, $valores);

    $datos = $result->fetch(PDO::FETCH_ASSOC);
    
    if ($datos['quantityInStock'] < 0) {
        trigger_error("No hay Stock del producto.", E_USER_ERROR);
    }
    
    echo "<p>Stock del producto <strong>". $datos['productName']. ":</strong> ". $datos['quantityInStock']. "</p>";
}

function seleccionarLineaProducto(){
    $sql = "SELECT DISTINCT productLine FROM products";
    $result = conexionBD($sql);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Opción por defecto
    echo "<option value=''>-- NO ASIGNADO --</option>";

    foreach ($datos as $row) {
        echo "<option value='". $row["productLine"]. "'>". $row["productLine"]. "</option>";
    }
}

function visualizarLineaProducto($productLine){
    $sql = "SELECT productLine, productCode, productName, quantityInStock
            FROM products
            WHERE productLine = :productLine
            ORDER BY quantityInStock DESC";
    $valores = [':productLine' => $productLine];
    $result = conexionBD($sql, $valores);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Productos de la linea <strong>". $productLine. ":</strong></p>";
    echo "<table border='1'>";
    echo "<tr><th>Código</th><th>Producto</th><th>Stock</th></tr>";
    foreach ($datos as $row) {
        echo "<tr><td>". $row["productCode"]. "</td><td>". $row["productName"]. "</td><td>". $row["quantityInStock"]. "</td></tr>";
    }
    echo "</table>";
    
}

function visualizarUnidadesFecha($usuario, $fechaInicio, $fechaFinal) {
    $sql = "SELECT a.productCode, c.productName, a.quantityOrdered, b.orderDate
            FROM orderdetails a 
            INNER JOIN orders b ON a.orderNumber = b.orderNumber 
            INNER JOIN products c ON a.productCode = c.productCode
            WHERE b.customerNumber = :customerNumber AND b.orderDate BETWEEN :FECHA_INICIO AND :FECHA_FINAL";
    $valores = [':customerNumber' => $usuario, ':FECHA_INICIO' => $fechaInicio, ':FECHA_FINAL' => $fechaFinal];
    $result = conexionBD($sql, $valores);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($result->rowCount() == 0) {
        echo "<p>No hay compras</p>";
    }else{
        echo "<h2>Productos comprados por ". $usuario. "</h2>";
        echo "<table border='1'>";
        echo "<tr><th>CODIGO PRODUCTO</th><th>NOMBRE</th><th>UNIDADES</th><th>FECHA_COMPRA</th></tr>";
        
        // Usamos los datos obtenidos
        foreach ($datos as $row) {
            echo "<tr><td>" . $row["productCode"] . "</td><td>" . $row["productName"] . "</td><td>" . $row["quantityOrdered"] . "</td><td>" . $row["orderDate"] . "</td></tr>";
        }
        echo "</table>";
    }
}

function listaUsuarios(){
    $sql = "SELECT customerNumber, customerName FROM customers";
    $result = conexionBD($sql);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Opción por defecto
    echo "<option value=''>-- NO ASIGNADO --</option>";

    foreach ($datos as $row) {
        echo "<option value='". $row["customerNumber"]. "'>" . $row["customerNumber"]. " - " . $row["customerName"]. "</option>";
    }
}

function visualizarPedidos($customerNumber){
    $sql = "SELECT a.orderNumber, a.orderDate, a.status, b.orderLineNumber, c.productName, b.quantityOrdered, b.priceEach
            FROM orders a 
            INNER JOIN orderdetails b ON a.orderNumber = b.orderNumber
            INNER JOIN products c ON b.productCode = c.productCode
            WHERE a.customerNumber = :customerNumber
            ORDER BY b.orderLineNumber";
    $valores = [':customerNumber' => $customerNumber];
    $result = conexionBD($sql, $valores);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($result->rowCount() == 0) {
        echo "<p>No hay pedidos</p>";
    }else{
        echo "<h2>Productos comprados por ". $customerNumber. "</h2>";
        echo "<table border='1'>";        
        echo "<tr><th>NUM. PEDIDO</th><th>FECHA PEDIDO</th><th>ESTADO PEDIDO</th><th>NUM. LINEA</th><th>NOMBRE PRODUCTO</th><th>CANTIDAD PEDIDA</th><th>PRECIO UNIDAD</th></tr>";
        
        // Usamos los datos obtenidos
        foreach ($datos as $row) {            
            echo "<tr><td>" . $row["orderNumber"] . "</td><td>" . $row["orderDate"] . "</td><td>" . $row["status"] . "</td><td>" . $row["orderLineNumber"] . "</td><td>" . $row["productName"] . "</td><td>" . $row["quantityOrdered"] . "</td><td>" . $row["priceEach"] . "</td></tr>";
        }
        echo "</table>";
    }
}

function visualizarPagos($customerNumber, $fechaInicio, $fechaFinal){
    if (empty($fechaInicio) || empty($fechaFinal)) {
        $sql = "SELECT checkNumber, paymentDate, amount
                FROM payments
                WHERE customerNumber = :customerNumber
                ORDER BY paymentDate DESC";
        $valores = [':customerNumber' => $customerNumber];
        $result = conexionBD($sql, $valores);
    }else{
        $sql = "SELECT checkNumber, paymentDate, amount
                FROM payments
                WHERE customerNumber = :customerNumber AND paymentDate BETWEEN :FECHA_INICIO AND :FECHA_FINAL
                ORDER BY paymentDate DESC";
        $valores = [':customerNumber' => $customerNumber, ':FECHA_INICIO' => $fechaInicio, ':FECHA_FINAL' => $fechaFinal];
        $result = conexionBD($sql, $valores);
    }
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($result->rowCount() == 0) {
        echo "<p>No hay pagos.</p>";
    }else{
        echo "<h2>Pagos realizados por <strong>". $customerNumber. ":</strong></h2>";
        echo "<table border='1'>";
        echo "<tr><th>NUM. PAGO</th><th>FECHA</th><th>IMPORTE</th></tr>";
        
        // Usamos los datos obtenidos
        foreach ($datos as $row) {
            echo "<tr><td>" . $row["checkNumber"] . "</td><td>" . $row["paymentDate"] . "</td><td>" . $row["amount"] . "</td></tr>";
        }
        echo "</table>";
        echo "<p><strong>Importe Total:</strong>". array_sum(array_column($datos, 'amount')). "</p>";
    }
}

function crearCookieCesta($productCode, $cantidad) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $nombreCookie = 'cesta_' . $_SESSION['usuario'];
    $cesta = obtenerCesta();
    $productoEncontrado = false;

    // Obtener el precio del producto desde la base de datos
    $precio = obtenerPrecioProducto($productCode);

    // Buscar si el producto ya existe en la cesta
    foreach ($cesta as &$producto) {
        if ($producto[0] === $productCode) {
            $producto[1] += $cantidad; // Actualizar cantidad
            $producto[2] = $precio;
            $productoEncontrado = true;
            break;
        }
    }

    // Si no existe, añadirlo
    if (!$productoEncontrado) {
        $nuevoProducto = [$productCode, $cantidad, $precio];
        $cesta[] = $nuevoProducto;
    }
    
    var_dump($cesta);
    
    // Serializar el cesta
    $cestaSerializado = serialize($cesta);
    
    // Crear o actualizar la cookie con duración de 7 días
    setcookie($nombreCookie, $cestaSerializado, time() + (7 * 24 * 60 * 60), "/");
}

function obtenerCesta() {
    // Asegúrate de que la sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $nombreCookie = 'cesta_' . $_SESSION['usuario'];

    if (isset($_COOKIE[$nombreCookie])) {
        $cesta = unserialize($_COOKIE[$nombreCookie]);
        
        // Validar que sea un array
        if (!is_array($cesta)) {
            $cesta = array();
        }
    } else {
        $cesta = array();
    }

    return $cesta;
}

function mostrarCesta() {
    $cesta = obtenerCesta();

    if (empty($cesta)) {
        echo "<p>La cesta está vacía.</p>";
        return;
    }

    echo "<ul>";
    foreach ($cesta as $producto) {
        $productCode = htmlspecialchars($producto[0]);
        $cantidad = htmlspecialchars($producto[1]);
        $precio = htmlspecialchars($producto[2]);

        echo "<li>Producto ID: $productCode - Cantidad: $cantidad - Precio: $precio</li>";
    }
    echo "</ul>";
}

function vaciarCesta() {
    // Asegúrate de que la sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $nombreCookie = 'cesta_' . $_SESSION['usuario'];
    setcookie($nombreCookie, '', time() - 3600, "/"); // Eliminar cookie
    echo "<p>La cesta ha sido vaciada.</p>";
}

//*******************************************++ */

function actualizarStock($productCode, $cantidad) {
    $sql = "SELECT productCode, quantityInStock 
            FROM products 
            WHERE productCode = :productCode";
    $valores = [':productCode' => $productCode];
    $result = conexionBD($sql, $valores);
    
    $datos = $result->fetch(PDO::FETCH_ASSOC);

    $cantidad_actual = $datos['quantityInStock'];
    
    if ($cantidad_actual >= $cantidad) {
        // Actualizar el almacén actual
        $sql_update = "UPDATE products 
                        SET quantityInStock = quantityInStock - :CANTIDAD
                        WHERE productCode = :productCode";
        $valores_update = [':CANTIDAD' => $cantidad, ':productCode' => $productCode];
        $valido = conexionBD($sql_update, $valores_update);
        
        if (!$valido) {
            trigger_error("Error al actualizar el stock del producto $productCode.", E_USER_ERROR);
        } else {
            echo "<p>Stock actualizado correctamente.</p>";
        }

    }else{
        echo "<p>No hay suficiente stock del producto $productCode.</p>";
    }
}

function disponibilidadStock($productCode, $cantidad){
    $sql = "SELECT quantityInStock
            FROM products 
            WHERE productCode = :productCode";
    $valores = [':productCode' => $productCode];
    $result = conexionBD($sql, $valores);
    
    $valido = true;

    $datos = $result->fetch(PDO::FETCH_ASSOC);

    if (!$datos) {
        $valido = false; // Producto no encontrado
    }
    
    if ($datos['quantityInStock'] < $cantidad) {
        $valido = false;
    }

    return $valido;
}

function realizarPedido($cliente){
    // Generamos el numero de orden
    $sql = "SELECT orderNumber FROM orders ORDER BY orderNumber DESC LIMIT 1";
    $result = conexionBD($sql);
    $numOrden = $result->fetch(PDO::FETCH_ASSOC);
    var_dump($numOrden);
    
    if ($numOrden) {
        $numOrden = $numOrden['orderNumber'] + 1;
    } else {
        $numOrden = 1;
    }

    // Insertamos el pedido
    $sql = "INSERT INTO orders (orderNumber, orderDate, requiredDate, shippedDate, status, comments, customerNumber) 
            VALUES (:orderNumber, CURDATE(), CURDATE() + INTERVAL 3 DAY, NULL, 'Shipped', NULL, :customerNumber)";
    $valores = [':orderNumber' => $numOrden, ':customerNumber' => $cliente];
    
    $valido = conexionBD($sql, $valores);
    
    if ($valido) {
        echo "<p>Pedido realizado correctamente</p>";
    }

    $cesta = obtenerCesta();
    $numLinea = 1;
    
    // Insertamos el detalle del pedido
    foreach ($cesta as $producto) {
        $productCode = htmlspecialchars($producto[0]);
        $cantidad = htmlspecialchars($producto[1]);
        
        $sql = "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber) 
            VALUES (:orderNumber, :productCode, :quantityOrdered, (SELECT buyPrice FROM products WHERE productCode = :productCode), :orderLineNumber)";
        $valores = [':orderNumber' => $numOrden, ':productCode' => $productCode, ':quantityOrdered' => $cantidad, ':orderLineNumber' => $numLinea];
        $valido = conexionBD($sql, $valores);

        $numLinea++;
    }
    
    if ($valido) {
        echo "<p>Detalles del pedido guardados correctamente</p>";
    }

}

function obtenerPrecioProducto($productCode) {
    $sql = "SELECT buyPrice FROM products WHERE productCode = :productCode";
    $valores = [':productCode' => $productCode];
    $res = conexionBD($sql, $valores);
    $valido = $res->fetch(PDO::FETCH_ASSOC);
    
    $precio = null;

    // Verificamos 
    if ($valido) {
        $precio = $valido['buyPrice']; // Asignamos el precio si lo encontramos
    }

    return $precio; 
}

function calcularTotalCesta() {
    $cesta = obtenerCesta();
    $total = 0;
    foreach ($cesta as $producto) {
        $cantidad = $producto[1];
        $precio = $producto[2];

        $total += $precio * $cantidad;
    }
    return $total; // Devuelve el total
}

function almacenarPedido($cliente, $checkNumber, $precioTotal){
    $cesta = obtenercesta();
    
    if (empty($cesta)) {
        trigger_error('No tienes productos en la cesta', E_USER_ERROR);
    }

    $productosNoDisponibles = [];
    $productosDisponibles = [];

    foreach ($cesta as $producto) {
        $productCode = $producto[0];
        $cantidad = $producto[1];

        $valido = disponibilidadStock($productCode, $cantidad);

        if ($valido) {
            $productosDisponibles[] = $producto;
        } else {
            $productosNoDisponibles[] = $productCode;
        }
    }

    foreach ($productosDisponibles as $producto) {
        $productCode = $producto[0];
        $cantidad = $producto[1];
        actualizarStock($productCode, $cantidad);
    }

    realizarPedido($cliente);

    if (!empty($productosNoDisponibles)) {
        echo "Productos sin stock: " . implode(', ', $productosNoDisponibles);
    } else {
        echo "Pago realizado con éxito.";
        vaciarCesta();

    }

}

function comprobarCheckNumber($cliente, $checkNumber){
    $sql = "SELECT customerNumber, checkNumber FROM payments WHERE customerNumber = :customerNumber and checkNumber = :checkNumber";
    $valores = [':customerNumber' => $cliente, ':checkNumber' => $checkNumber];
    $res = conexionBD($sql, $valores);
    $valido = $res->fetch(PDO::FETCH_ASSOC);

    // Si no se encuentra un registro, $existe será false
    $existe = $valido ? true : false;

    return $existe; 
}

function actualizarRegistroPayments($cliente, $checkNumber, $precioTotal){
    $sql = "UPDATE payments SET paymentDate = CURDATE(), amount = :amount WHERE customerNumber = :customerNumber AND checkNumber = :checkNumber";
    $valores = [':customerNumber' => $cliente, ':checkNumber' => $checkNumber, ':amount' => $precioTotal];
    conexionBD($sql, $valores); 
}

function cookieCheckNumber($checkNumber){
    // Guardar el checkNumber en una cookie
    setcookie("checkNumber", $checkNumber, time() + 3600, "/"); // Expira en 1 hora
}

function guardarPago($cliente, $checkNumber, $precioTotal){
    $sql = "INSERT INTO payments (customerNumber, checkNumber, paymentDate, amount) 
            VALUES (:customerNumber, :checkNumber, CURDATE(), :amount)";
    $valores = [':customerNumber' => $cliente, ':checkNumber' => $checkNumber, ':amount' => $precioTotal];
    $valido = conexionBD($sql, $valores);
    
    if ($valido) {
        echo "<p>Pago registrado correctamente</p>";
    }
}

?>