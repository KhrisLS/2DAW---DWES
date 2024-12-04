<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function buscarUltCategoria(){
    $sql = "SELECT ID_CATEGORIA FROM categoria ORDER BY ID_CATEGORIA DESC LIMIT 1";
    $resultado = conexionBD($sql);

    if ($resultado->rowCount() == 0) {
        return 'C-000';   
    }

    $linea = $resultado->fetch(PDO::FETCH_ASSOC);
    $ultCategoria = $linea['ID_CATEGORIA'];

    return $ultCategoria;
}

function generarCodCategoria($ultCategoria){
    
    $id_cat = intval(substr($ultCategoria, 2)) + 1;
    $nuevaCat = 'C-'.str_pad($id_cat, 3, '0', STR_PAD_LEFT);

    return $nuevaCat;
}

function crearCategoria($id_cat, $nombre){

    $sql = "INSERT INTO categoria (ID_CATEGORIA, NOMBRE) VALUES (:ID_CATEGORIA, :NOMBRE)";
    $valores = [':ID_CATEGORIA' => $id_cat, ':NOMBRE' => $nombre];
    
    $valido = conexionBD($sql, $valores);

    if ($valido) {
        echo "<p>Categoría creado correctamente</p>";
    }
}

function listaCategorias(){    
    $sql = "SELECT ID_CATEGORIA, NOMBRE FROM categoria";
    $result = conexionBD($sql);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Opción por defecto
    echo "<option value=''>-- NO ASIGNADO --</option>";

    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<option value='" . $row["ID_CATEGORIA"] . "'>" . 
             $row["ID_CATEGORIA"] . " - " . $row["NOMBRE"] . "</option>";
    }
}

function buscarUltProducto(){
    $sql = "SELECT ID_PRODUCTO FROM producto ORDER BY ID_PRODUCTO DESC LIMIT 1";
    $resultado = conexionBD($sql);

    if ($resultado->rowCount() == 0) {
        return 'P0000';   
    }

    $linea = $resultado->fetch(PDO::FETCH_ASSOC);
    $ultProducto = $linea['ID_PRODUCTO'];

    return $ultProducto;
}

function generarCodProducto($ultProducto){
    
    $id_producto = intval(substr($ultProducto, 1)) + 1;
    $nuevoProducto = 'P'.str_pad($id_producto, 4, '0', STR_PAD_LEFT);

    return $nuevoProducto;
}

function crearProducto($id_producto, $nombre, $precio, $id_cat){
    $sql = "INSERT INTO producto (ID_PRODUCTO, NOMBRE, PRECIO, ID_CATEGORIA) VALUES (:ID_PRODUCTO, :NOMBRE, :PRECIO, :ID_CATEGORIA)";
    $valores = [':ID_PRODUCTO' => $id_producto, ':NOMBRE' => $nombre, ':PRECIO' => $precio, ':ID_CATEGORIA' => $id_cat];
    
    $valido = conexionBD($sql, $valores);

    if ($valido) {
        echo "<p>Producto creado correctamente</p>";
    }
}

function buscarUltAlmacen(){
    $sql = "SELECT NUM_ALMACEN FROM almacen ORDER BY NUM_ALMACEN DESC LIMIT 1";
    $resultado = conexionBD($sql);

    if ($resultado->rowCount() == 0) {
        return '0';   
    }

    $linea = $resultado->fetch(PDO::FETCH_ASSOC);
    $ultAlmacen = $linea['NUM_ALMACEN'];

    return $ultAlmacen;
}

function generarCodAlmacen($ultAlmacen){
    
    $nuevoAlmacen = $ultAlmacen + 1;

    return $nuevoAlmacen;
}

function crearAlmacen($numAlmacen, $localidad){
    $sql = "INSERT INTO almacen (NUM_ALMACEN, LOCALIDAD) VALUES (:NUM_ALMACEN, :LOCALIDAD)";
    $valores = [':NUM_ALMACEN' => $numAlmacen, ':LOCALIDAD' => $localidad];
    
    $valido = conexionBD($sql, $valores);

    if ($valido) {
        echo "<p>Almacén creado correctamente</p>";
    }
}


function listaAlmacenes(){    
    $sql = "SELECT NUM_ALMACEN, LOCALIDAD FROM almacen";
    $result = conexionBD($sql);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Opción por defecto
    echo "<option value=''>-- NO ASIGNADO --</option>";

    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<option value='" . $row["NUM_ALMACEN"] . "'>" . 
             $row["NUM_ALMACEN"] . " - " . $row["LOCALIDAD"] . "</option>";
    }
}

function listaProductos(){    
    $sql = "SELECT ID_PRODUCTO, NOMBRE FROM producto";
    $result = conexionBD($sql);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Opción por defecto
    echo "<option value=''>-- NO ASIGNADO --</option>";

    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<option value='" . $row["ID_PRODUCTO"] . "'>" . 
             $row["ID_PRODUCTO"] . " - " . $row["NOMBRE"] . "</option>";
    }
}

function asignarStock($num_almacen, $id_producto, $cantidad){
    $sql = "SELECT CANTIDAD FROM almacena WHERE NUM_ALMACEN = '$num_almacen' AND ID_PRODUCTO = '$id_producto'";
    $resultado = conexionBD($sql);

    if ($resultado->rowCount() == 0) {
        $sql = "INSERT INTO almacena (NUM_ALMACEN, ID_PRODUCTO, CANTIDAD) VALUES (:NUM_ALMACEN, :ID_PRODUCTO, :CANTIDAD)";
        $valores = [':NUM_ALMACEN' => $num_almacen, ':ID_PRODUCTO' => $id_producto, ':CANTIDAD' => $cantidad];
    
        $valido = conexionBD($sql, $valores);
        if ($valido) {
            echo "<p>Stock actualizado correctamente</p>";
        }
    }else{
        $linea = $resultado->fetch(PDO::FETCH_ASSOC);
        $cantidadExistente = $linea['CANTIDAD'];

        $nuevaCantidad = $cantidadExistente + $cantidad;

        $sql = "UPDATE almacena SET CANTIDAD = :CANTIDAD WHERE NUM_ALMACEN = :NUM_ALMACEN AND ID_PRODUCTO = :ID_PRODUCTO";
        $valores = [':NUM_ALMACEN' => $num_almacen, ':ID_PRODUCTO' => $id_producto, ':CANTIDAD' => $nuevaCantidad];
        
        $valido = conexionBD($sql, $valores);
        if ($valido) {
            echo "<p>Stock actualizado correctamente</p>";
        }
    }
}

function visualizarStock($id_producto){
    $sql = "SELECT a.NUM_ALMACEN, a.CANTIDAD, c.LOCALIDAD FROM almacena a INNER JOIN almacen c ON a.NUM_ALMACEN = c.NUM_ALMACEN WHERE a.ID_PRODUCTO = '$id_producto'";
    $result = conexionBD($sql);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($result->rowCount() == 0) {
        echo "<p>No hay stock para el producto</p>";
    }else{
        echo "<h2>Stock de producto ". $id_producto. "</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Número Almacén</th><th>Cantidad</th><th>Localidad</th></tr>";
        // Usamos los datos obtenidos
        foreach ($datos as $row) {
            echo "<tr><td>" . $row["NUM_ALMACEN"] . "</td><td>" . $row["CANTIDAD"] . "</td><td>" . $row["LOCALIDAD"] . "</td></tr>";
        }
        echo "</table>";
    }
}

function visualizarAlmacenes($num_almacen){
    $sql = "SELECT a.ID_PRODUCTO, p.NOMBRE, a.CANTIDAD, c.LOCALIDAD 
            FROM almacena a INNER JOIN almacen c ON a.NUM_ALMACEN = c.NUM_ALMACEN 
            INNER JOIN producto p ON a.ID_PRODUCTO = p.ID_PRODUCTO 
            WHERE a.NUM_ALMACEN = :NUM_ALMACEN";
    $valores = [':NUM_ALMACEN' => $num_almacen];
    $result = conexionBD($sql, $valores);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($result->rowCount() == 0) {
        echo "<p>No hay productos en el almacén</p>";
    }else{
        echo "<h2>Productos disponibles en el almacén ". $num_almacen. "</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID PRODUCTO</th><th>NOMBRE PRODUCTO</th><th>CANTIDAD</th><th>LOCALIDAD</th></tr>";
        // Usamos los datos obtenidos
        foreach ($datos as $row) {
            echo "<tr><td>" . $row["ID_PRODUCTO"] . "</td><td>" . $row["NOMBRE"] . "</td><td>" . $row["CANTIDAD"] . "</td><td>" . $row["LOCALIDAD"] . "</td></tr>";
        }
        echo "</table>";
    }
}

function listaClientes(){    
    $sql = "SELECT NIF, NOMBRE FROM cliente";
    $result = conexionBD($sql);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);
    
    // Opción por defecto
    echo "<option value=''>-- NO ASIGNADO --</option>";

    // Usamos los datos obtenidos
    foreach ($datos as $row) {
        echo "<option value='" . $row["NIF"] . "'>" . 
             $row["NIF"] . " - " . $row["NOMBRE"] . "</option>";
    }
}

function visualizarCompras($nif, $fechaInicio, $fechaFinal){
    $sql = "SELECT c.ID_PRODUCTO, p.NOMBRE, p.PRECIO, c.UNIDADES, c.FECHA_COMPRA, (p.PRECIO * c.UNIDADES) AS TOTAL
            FROM COMPRA c 
            INNER JOIN PRODUCTO p ON c.ID_PRODUCTO = p.ID_PRODUCTO 
            WHERE c.NIF = :NIF AND c.FECHA_COMPRA BETWEEN :FECHA_INICIO AND :FECHA_FINAL";
    $valores = [':NIF' => $nif, ':FECHA_INICIO' => $fechaInicio, ':FECHA_FINAL' => $fechaFinal];
    $result = conexionBD($sql, $valores);
    
    $datos = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($result->rowCount() == 0) {
        echo "<p>No hay compras</p>";
    }else{
        echo "<h2>Productos comprados por ". $nif. "</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID PRODUCTO</th><th>NOMBRE</th><th>PRECIO</th><th>UNIDADES</th><th>FECHA_COMPRA</th><th>TOTAL</th></tr>";
        
        $precioTotal = 0;
        
        // Usamos los datos obtenidos
        foreach ($datos as $row) {
            echo "<tr><td>" . $row["ID_PRODUCTO"] . "</td><td>" . $row["NOMBRE"] . "</td><td>" . $row["PRECIO"] . "</td><td>" . $row["UNIDADES"] . "</td><td>" . $row["FECHA_COMPRA"] . "</td><td>" . $row["TOTAL"] . "</td></tr>";
            $precioTotal += $row["TOTAL"];
        }
        echo "</table>";
        echo "<h3>Total de las ventas: " . number_format($precioTotal, 2) . " €</h3>";
    }
}

function validarNif($nif){
    $expresionRegular = '/^[0-9]{8}[A-Z]$/';
    $valido = true;
    
    if (!preg_match($expresionRegular, $nif)) {
        trigger_error("El NIF debe tener 8 dígitos seguidos de una letra.", E_USER_ERROR);
        $valido = false;
    } 

    return $valido;
}

function clienteExiste($nif){
    $sql = "SELECT NIF FROM cliente WHERE NIF = :NIF";
    $valores = [':NIF' => $nif];
    $resultado = conexionBD($sql, $valores);

    $valido = false;

    if ($resultado->rowCount() !== 0) {
        trigger_error("Ya existe un cliente con el NIF $nif.", E_USER_ERROR);   
        $valido = true;
    }

    return $valido;
}

function usuarioExiste($usuario){
    $sql = "SELECT USUARIO FROM cliente WHERE USUARIO = :USUARIO";
    $valores = [':USUARIO' => $usuario];
    $resultado = conexionBD($sql, $valores);

    $valido = false;

    if ($resultado->rowCount() !== 0) {
        trigger_error("Ya existe un cliente con el usuario '$usuario'. Por favor, elija otro.", E_USER_ERROR);   
        $valido = true;
    }

    return $valido;
}

function altaCliente($nif, $nombre, $apellido, $cp, $dir, $ciudad, $usuario, $clave, $claveSinCifrar){
    $sql = "INSERT INTO cliente (NIF, NOMBRE, APELLIDO, CP, DIRECCION, CIUDAD, USUARIO, CLAVE) VALUES (:NIF, :NOMBRE, :APELLIDO, :CP, :DIRECCION, :CIUDAD, :USUARIO, :CLAVE)";
    $valores = [':NIF' => $nif, ':NOMBRE' => $nombre, ':APELLIDO' => $apellido, ':CP' => $cp, ':DIRECCION' => $dir, ':CIUDAD' => $ciudad, ':USUARIO' => $usuario, ':CLAVE' => $clave];
    
    $valido = conexionBD($sql, $valores);

    if ($valido) {
        echo "<p>Registro realizado correctamente. Su usuario es '$usuario' y su clave es '$claveSinCifrar'.</p>";
    }
}

function disponibilidadStock($id_producto, $cantidad){
    $sql = "SELECT SUM(CANTIDAD) AS STOCK_DISPONIBLE 
            FROM almacena 
            WHERE ID_PRODUCTO = :ID_PRODUCTO";
    $valores = [':ID_PRODUCTO' => $id_producto];
    $result = conexionBD($sql, $valores);
    
    $valido = true;

    $datos = $result->fetch(PDO::FETCH_ASSOC);
    
    if ($datos['STOCK_DISPONIBLE'] < $cantidad) {
        trigger_error("No hay suficiente stock para realizar la compra.", E_USER_ERROR);
        $valido = false;
    }

    return $valido;
}

function realizarCompra($nif, $id_producto, $unidades){
    $sql = "INSERT INTO compra (NIF, ID_PRODUCTO, FECHA_COMPRA, UNIDADES) VALUES (:NIF, :ID_PRODUCTO, CURDATE(), :UNIDADES)";
    $valores = [':NIF' => $nif, ':ID_PRODUCTO' => $id_producto, ':UNIDADES' => $unidades];
    
    $valido = conexionBD($sql, $valores);

    if ($valido) {
        echo "<p>Compra realizada correctamente</p>";
    }
}

function actualizarStock($id_producto, $cantidad) {
    $sql = "SELECT NUM_ALMACEN, CANTIDAD 
            FROM almacena 
            WHERE ID_PRODUCTO = :ID_PRODUCTO 
            ORDER BY NUM_ALMACEN ASC";
    $valores = [':ID_PRODUCTO' => $id_producto];
    $resultado = conexionBD($sql, $valores);
    $almacenes = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($almacenes as $almacen) {
        $cantidad_actual = $almacen['CANTIDAD'];
        $num_almacen = $almacen['NUM_ALMACEN'];

        if ($cantidad_actual >= $cantidad) {
            // Actualizar el almacén actual
            $sql_update = "UPDATE almacena 
                           SET CANTIDAD = CANTIDAD - :CANTIDAD 
                           WHERE NUM_ALMACEN = :NUM_ALMACEN AND ID_PRODUCTO = :ID_PRODUCTO";
            $valores_update = [':CANTIDAD' => $cantidad, ':NUM_ALMACEN' => $num_almacen, ':ID_PRODUCTO' => $id_producto];
            $valido = conexionBD($sql_update, $valores_update);
            
            if (!$valido) {
                trigger_error("Error al actualizar el stock del almacén $num_almacen.", E_USER_ERROR);
            } else {
                echo "<p>Stock actualizado correctamente.</p>";
            }

            break; // Se ha alcanzado la cantidad deseada en el almacén
            
        } else {
            // Usar el stock del almacén actual y continuar con el siguiente
            $sql_update = "UPDATE almacena 
                           SET CANTIDAD = 0 
                           WHERE NUM_ALMACEN = :NUM_ALMACEN AND ID_PRODUCTO = :ID_PRODUCTO";
            $valores_update = [':NUM_ALMACEN' => $num_almacen, ':ID_PRODUCTO' => $id_producto];
            conexionBD($sql_update, $valores_update);
            
            $cantidad -= $cantidad_actual;
        }
    }
}

function verificarLogin($usuario, $clave) {
    $sql = "SELECT * FROM cliente WHERE USUARIO = :USUARIO";
    $valores = [':USUARIO' => $usuario];
    $result = conexionBD($sql, $valores);

    $cliente = $result->fetch(PDO::FETCH_ASSOC);

    if ($cliente && password_verify($clave, $cliente['CLAVE'])) {
        $_SESSION['usuario'] = $cliente['USUARIO'];
        $_SESSION['nif'] = $cliente['NIF'];
        
        echo "<p>Inicio de sesión exitoso. Bienvenido, $usuario.</p>";
        //header("Location: portal.php"); // Redirige al portal de compras
    } else {
        trigger_error("Usuario o clave incorrectos.", E_USER_ERROR);
    }
}

?>