<?php
    require_once ("models/movalquilar_model.php");
    require_once ("controllers/funciones_controller.php");
    require_once("views/movalquilar.php");

    // Verificar si el formulario fue enviado y qué botón se presionó
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $matricula = $_POST['matricula'];
        $matricula = test_input($matricula);
        $cliente = $_SESSION['usuario']['idcliente'];

        if (isset($_POST['agregar'])) {
            if (empty($matricula)) {
                trigger_error("No se ha seleccionado un vehículo.", E_USER_WARNING);
            }   

            crearCookieCesta($matricula);
        }


        if (isset($_POST['alquilar'])) {
            // Procesar la solicitud de alquiler (puedes agregar la lógica de alquiler aquí)
            $valido = comprobarListadoAlquileres($cliente);

            if($valido){
                alquilarVehiculos($cliente);
            }else{
                trigger_error("Máximo alquileres alcanzados (3 por cliente).", E_USER_WARNING);
            }
        }

        
        if (isset($_POST['vaciar'])) {
            // Vaciar el carrito
            vaciarCesta();
        }
    }


    //============================================== FUNCIONES =================================================

    function disponibleFechaHora(){
        echo fechaHoraActual();
    }

    function listaVehiculos(){
        $vehiculos = vehiculosDisponibles();

        // Opción por defecto
        echo "<option value=''>-- SELECCIONA UNA OPCIÓN --</option>";

        // Usamos los datos obtenidos
        foreach ($vehiculos as $row) {
            echo "<option value='" . $row["matricula"] . "'>" . $row["marca"] . " - " . $row["modelo"]. "</option>";
        }
    }

    function crearCookieCesta($matricula) {
        
        $nombreCookie = 'cesta_' . $_SESSION['usuario']['nombre'];
        $cesta = obtenerCesta();
        $vehiculoEncontrado = false;

         // Limitar la cesta a un máximo de 3 vehículos
        if (count($cesta) >= 3) {
            echo "La cesta está completa (Máximo 3 vehículos).";
            listarCesta($cesta);
            return;
        }
    
        // Buscar si el producto ya existe en la cesta
        foreach ($cesta as $vehiculo) {
            if ($vehiculo === $matricula) {
                echo "Ya existe en la cesta un vehículo con la matrícula $matricula";
                $vehiculoEncontrado = true;
                break;
            }
        }
    
        // Si el vehículo no está en la cesta, lo añadimos
        if (!$vehiculoEncontrado) {
            $nuevoVehiculo = $matricula;
            $cesta[] = $nuevoVehiculo;
            echo "Vehículo añadido correctamente.";
        }
        
        // Serializar el cesta
        $cestaSerializado = serialize($cesta);
        
        // Crear o actualizar la cookie con duración de 7 días
        setcookie($nombreCookie, $cestaSerializado, time() + (7 * 24 * 60 * 60), "/");

        listarCesta($cesta);
    }

    function obtenerCesta() {
        
        $nombreCookie = 'cesta_' . $_SESSION['usuario']['nombre'];
    
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

    function vaciarCesta() {
        // Asegúrate de que la sesión esté iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        $nombreCookie = 'cesta_' . $_SESSION['usuario']['nombre'];
        setcookie($nombreCookie, '', time() - 3600, "/"); // Eliminar cookie
        echo "<p>La cesta ha sido vaciada.</p>";
    }

    function listarCesta($cesta){
        echo "<br><br>";
        echo "<table class='table table-bordered'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Matrícula</th>";
        echo "<th>Marca</th>";
        echo "<th>Modelo</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Iterar sobre los elementos de la cesta
        foreach ($cesta as $vehiculo) {
            $datos = detallesVehiculo($vehiculo);
            $marca = $datos[0]['marca'];
            $modelo = $datos[0]['modelo'];
            echo "<tr>";
            echo "<td>" . htmlspecialchars($vehiculo) . "</td>";
            echo "<td>" . htmlspecialchars($marca) . "</td>";
            echo "<td>" . htmlspecialchars($modelo) . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    function comprobarListadoAlquileres($cliente){
        $resultado = alquilerPorPersona($cliente);
        $valido = false;
        // Número de alquileres
        $totalAlquileres = (int)$resultado[0]['total_alquileres'];

        // Verificar si el cliente tiene menos de 3 alquileres
        if ($totalAlquileres >= 3) {
            $valido = false; // No puede alquilar
        } else {
            $valido = true; // Puede alquilar
        }

        return $valido;
    }

    function alquilarVehiculos($cliente){
        $cesta = obtenerCesta();

        foreach($cesta as $vehiculo){
            $valido = realizarAlquiler($cliente, $vehiculo);
            if ($valido) {
                actualizarDisponibilidadVehiculo($vehiculo, 'N');
                echo "<p>Vehiculo $vehiculo alquilado correctamente</p>";
            } else {
                echo "<p>Error al alquilar el vehículo $vehiculo</p>";
            }
        }

        // Vaciar la cesta
        vaciarCesta();
    }
?>