<?php
function comprobarMismoDia($emp) {
    $diaModificacion = obtenerDiaUltimaModificacion($emp);

    if (!empty($diaModificacion)) {
      $diaModificacion = $diaModificacion[0]['from_date'];
      
      if ($diaModificacion == date('Y-m-d'))
        trigger_error('No se puede modificar el salario de un empleado más de una vez en el mismo día', E_USER_WARNING);
    }
}

function modificarSalario($emp, $salario) {
    if ($emp == '' || $salario == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);

    $validoActualizar = actualizarSalarioExistente($emp);
    $validoInsertar = insertarNuevoSalario($emp, $salario);
    
    if ($validoActualizar && $validoInsertar) {
        echo "Salario modificado con éxito";
    }else{
        trigger_error('No se ha podido modificar el salario', E_USER_WARNING);
    }
}

?>