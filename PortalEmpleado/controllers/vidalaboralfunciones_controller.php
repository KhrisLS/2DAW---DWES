<?php
function mostrarDatosPersonales($emp) {
    if ($emp == '')
      trigger_error('Debes elegir un empleado', E_USER_WARNING);

    $datos = datosPersonales($emp);
    
    mostrarInfo($datos);
}

function mostrarHistorialDepartamentos($emp) {
    if ($emp == '')
      trigger_error('Debes elegir un empleado', E_USER_WARNING);

    $datos = departamentos($emp);

    mostrarDepts($datos);
}

function mostrarHistorialCargos($emp) {
    if ($emp == '')
      trigger_error('Debes elegir un empleado', E_USER_WARNING);

    $datos = cargos($emp);

    $datosManager = cargoManager($emp);

    if(!empty($datosManager)) {
        mostrarCargoManager($datosManager);
    }
    mostrarCargos($datos);
    
}

function mostrarHistorialSalarios($emp) {
    if ($emp == '')
      trigger_error('Debes elegir un empleado', E_USER_WARNING);

    $datos = salarios($emp);

    mostrarSalarios($datos);
}
?>