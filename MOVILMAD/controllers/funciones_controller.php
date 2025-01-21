<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function cerrarSesion() {
    setcookie(session_name(), '', time() - 3600, '/');
    session_unset();
    session_destroy();
}

// Se establece el Error handler
set_error_handler('errores', E_USER_WARNING);

// Mostrar errores
function errores($errno, $errstr) {
    echo "<strong>ERROR:</strong> $errstr <br>";
    die();
}

// limpiar los datos de entrada
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>