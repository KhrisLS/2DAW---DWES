<?php
function login($user, $password) {
    if ($user == '' || $password == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);

    $empleado = comprobarUser($user);
    
    //contraseña incorrecta o usuario inexistente
    if (empty($empleado) || $password != $empleado['last_name'])
      trigger_error('Login inválido', E_USER_WARNING);

    $dept = comprobarDepartamento($user);

    $numDept = $dept['dept_no'];

    session_start();
    $_SESSION['usuario'] = [
      'emp_no' => $empleado['emp_no'],
      'nombre' => $empleado['first_name'],
      'dept' => $numDept
    ];
    
    //Si no pertenece al departamento de RRHH, redirige a otro portal
    if ($dept['dept_no'] != 'd003'){
      header("Location: portalEmpleado.php");
    }else{
      //Si pertenece, redirige al portal correspondiente
      header("Location: portalRRHH.php");
    }
    exit();
    
}
?>