<?php
// Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
require_once('controllers/comun_controller.php');

comprobarSesion();

require_once ("controllers/vreservasfunciones_controller.php");
require_once ("models/vreservas_model.php");
require_once('views/vreservas.php');

// Verificar si el formulario fue enviado y qué botón se presionó
if ($_SERVER['REQUEST_METHOD'] === 'POST') {   
    if (isset($_POST['ver'])) {
        $vuelosAgregados = isset($_COOKIE['vuelosAgregados']) ? unserialize($_COOKIE['vuelosAgregados']) : array();
        mostrarVuelosAgregados($vuelosAgregados);
    }

    if (isset($_POST['agregar'])) {
        $vuelo = $_POST['vuelos'] ?? '';
        $num = $_POST['asientos'];

        limpiar($vuelo);
        limpiar($num);

        comprobarVacio($vuelo);
        comprobarVacio($num);

        $vuelosAgregados = array();
  
        crearCookieCesta($vuelosAgregados, $vuelo, $num);
        mostrarVuelosAgregados($vuelosAgregados);
    }

    if (isset($_POST['comprar'])) {
        comprobarAsientosDisponibles();
        $precioTotal = hacerReserva();
        vaciarCesta();
        echo 'Se han pagado los vuelos correctamente. Precio total: ' . $precioTotal . '€';
        
    }

    if (isset($_POST['vaciar'])) {
        // Vaciar el carrito
        vaciarCesta();
        echo 'Se han eliminado los vuelos agregados';
    }

    if (isset($_POST['volver'])){
        redireccionar('vinicio.php');
    }
}

?>