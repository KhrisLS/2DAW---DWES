<?php
require_once ("models/login_model.php");
require_once ("controllers/funcionesgenerales_controller.php");
require_once ("controllers/loginfunciones_controller.php");
require_once('views/login_view.php');

// En caso de que ya tenga la sesión iniciada, redirigir
if (isset($_SESSION['usuario'])) {
  if($_SESSION['usuario']['dept'] != 'd003'){
    header("Location: portalEmpleado.php");
  }else{
    header("Location: portalRRHH.php");
  }
  exit();
}else{
  cerrarSesion();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $password = $_POST['password'];

    $user = test_input($user);
    $password = test_input($password);

    login($user, $password);
}

?>
