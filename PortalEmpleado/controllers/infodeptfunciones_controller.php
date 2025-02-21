<?php
function buscarManager($dept){
    $datos = obtenerManager($dept);

    mostrarManager($datos);
}

function buscarEmpleados($dept){
    $datos = obtenerEmpleados($dept);

    mostrarEmpleados($datos);
}
?>