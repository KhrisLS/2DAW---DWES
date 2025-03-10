<?php
function login($user, $password) {
    // Buscar si existe el empleado
    $cliente = datosCliente($user);
    
    if (!$cliente){
      trigger_error('Usuario inexistente', E_USER_WARNING);
      return false;
    }

    $passCliente = intval(substr($cliente['dni'], 0, 4));

    //contraseña incorrecta o usuario inexistente
    if ($passCliente != $password){
      trigger_error('Contraseña incorrecta', E_USER_WARNING);
      return false;
    }
    
    $_SESSION['usuario'] = $cliente['email'];
    
    return true;
}
?>