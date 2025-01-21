<?php
    require_once ("models/movalquilar_model.php");
    require_once ("controllers/funciones_controller.php");
    require_once("views/movalquilar.php");

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

    
    // Verificar si el formulario fue enviado y qué botón se presionó
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $matricula = $_POST['matricula'];
        $matricula = test_input($matricula);

        if (isset($_POST['agregar'])) {
            if (empty($matricula)) {
                trigger_error("No se ha seleccionado un vehículo.", E_USER_WARNING);
            }   
            
            crearCookieCesta($matricula);

        }


        if (isset($_POST['alquilar'])) {
            // Procesar la solicitud de alquiler (puedes agregar la lógica de alquiler aquí)
            
        }

        
        if (isset($_POST['vaciar'])) {
            // Vaciar el carrito
            
        }
    }


    //============================================== FUNCIONES =================================================

    function crearCookieCesta($matricula) {
        
        $nombreCookie = 'cesta_' . $_SESSION['usuario']['nombre'];
        $cesta = obtenerCesta();
        $productoEncontrado = false;

        
    
        // Buscar si el producto ya existe en la cesta
        foreach ($cesta as &$vehiculo) {
            if ($producto[0] === $matricula) {
                $producto[1] = $marca; 
                $producto[2] = $modelo;
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

?>