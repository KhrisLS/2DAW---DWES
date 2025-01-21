<?php

require_once ("models/movlogin_model.php");
require_once ("controllers/funciones_controller.php");
require_once('views/movlogin.php');

// En caso de que ya tenga la sesión iniciada redirigir al welcome
if (isset($_SESSION['usuario'])) {
  header("Location: views/movwelcome.php"); // Redirigir 
  exit();
}else{
  cerrarSesion();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    var_dump($email);
    var_dump($password);

    login($email, $password);
    header('Location: views/movwelcome.php');
    exit();
}

function login($email, $password) {
    // Si alguno de los campos esté vacío da error
    if ($email == '' || $password == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);

    // Buscar si existe el cliente
    $cliente = buscarEmail($email);
    
    // Si el cliente no existe o no es correcta la contraseña da error
    if (empty($cliente) || $password != $cliente['idcliente'])
      trigger_error('Login inválido', E_USER_WARNING);

    // Si el cliente ha sido dado de baja da error
    if ($cliente['fecha_baja'] != null)
      trigger_error('El cliente ha sido dado de baja', E_USER_WARNING);

    // Si el cliente tiene pagos pendientes da error
    if ($cliente['pendiente_pago'] > 0)
      trigger_error('El cliente tiene pagos pendientes', E_USER_WARNING);

    // Inicia la sesión del cliente
    session_start();
    $_SESSION['usuario'] = $cliente['idcliente'];
  }

?>
