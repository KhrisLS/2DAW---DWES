<?php
//Se inicia la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("comun_funciones_controller.php");

// Se establece el Error handler
set_error_handler('errores', E_USER_WARNING);

?>