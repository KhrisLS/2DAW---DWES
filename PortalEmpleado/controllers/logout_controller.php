<?php
function cerrarSesion(){
    // Asegúrate de que no se haya iniciado ya la sesión
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Elimina la cookie asociada a la sesión
    setcookie(session_name(), '', time() - 3600, '/');
    
    // Elimina variables de sesión
    $_SESSION = array();
    
    // Elimina la sesión
    session_destroy();

    // Redirigir al usuario a la página de inicio de sesión o página principal
    header("Location: ../index.php");
    exit();
}

cerrarSesion(); 

?>