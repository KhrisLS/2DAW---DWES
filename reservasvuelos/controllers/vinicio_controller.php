<?php
// Iniciar sesión, error handler y funciones limpiar, redireccionar y logout
require_once('controllers/comun_controller.php');

// Depuración
echo "Estado de la sesión: " . session_status() . "<br>";
echo "Session ID: " . session_id() . "<br>";
echo "Contenido de la sesión: ";
var_dump($_SESSION);
echo "<hr>";  

comprobarSesion();

require_once ("controllers/viniciofunciones_controller.php");
require_once ("models/vinicio_model.php");
require_once('views/vinicio.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reservar'])) {
        redireccionar('reservas.php');

    } else if (isset($_POST['consultar'])) {
        redireccionar('consultas.php');

    } else if (isset($_POST['salir'])) {
        logout();
        redireccionar('.');
    }

}


?>