<?php
function asignarNumEmpleado() {
    $numEmp = ultimoNumEmpleado();
    $nuevoNumEmp = $numEmp['emp_no'] + 1;

    return $nuevoNumEmp;
}

function darAltaEmpleado($numEmp, $nombre, $apellido, $nacimiento, $genero, $dept, $salario, $cargo){
    if ($nombre == '' || $apellido == '' || $nacimiento == '' || $genero == '' || $dept == '' || $salario == '' || $cargo == '')
      trigger_error('Debes rellenar todos los campos', E_USER_WARNING);

    $validoAltaEmp = realizarAltaEmp($numEmp, $nombre, $apellido, $nacimiento, $genero);
    $validoDept = realizarAltaEnDept($numEmp, $dept);
    $validoSalario = realizarAltaEnSalario($numEmp, $salario);
    $validoCargo = realizarAltaEnCargo($numEmp, $cargo);

    if ($validoAltaEmp && $validoDept && $validoSalario && $validoCargo){
        echo "Alta realizada con éxito";
    }else{
        trigger_error('No se ha podido dar de alta al empleado', E_USER_WARNING);
    }
}
?>