<?php
function mostrarEmail(){
    echo datosCliente($_SESSION['usuario'])['email'];
}

function mostrarNombre(){
    $cliente = datosCliente($_SESSION['usuario']);
    echo $cliente['nombre'] . ' ' . $cliente['apellidos'];
}

function mostrarFecha(){
    date_default_timezone_set('Europe/Madrid');
    echo date('d/m/Y');
}
?>