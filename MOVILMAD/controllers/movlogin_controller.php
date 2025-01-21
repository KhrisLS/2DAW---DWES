<?php
require_once ("models/movlogin_model.php");
require_once ("controllers/funciones_controller.php");
require_once('views/movlogin.php');

// Redirigir al welcome si existe una sesion
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
    if ($email == '' || $password == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);

    $cliente = comprobarEmail($email);
    
    //---------------------COMPROBACIONES DE ERROR--------------------------------
    //contraseña incorrecta o usuario inexistente
    if (empty($cliente) || $password != $cliente['idcliente'])
      trigger_error('Login inválido', E_USER_WARNING);

    //cliente de baja
    if ($cliente['fecha_baja'] != null)
      trigger_error('El cliente ha sido dado de baja', E_USER_WARNING);

    //pagos pendientes
    if ($cliente['pendiente_pago'] > 0)
      trigger_error('El cliente tiene pagos pendientes', E_USER_WARNING);

    
    session_start();
    $_SESSION['usuario'] = $cliente['idcliente'];
  }

?>
