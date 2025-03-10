<?php

require_once('db/funciones.php');

function datosCliente($user) {
    $sql = "SELECT *
            FROM clientes
            WHERE email = :email";
    $valores = [':email' => $user];
    $resultado = operarBd($sql, $valores);

    return $resultado ? $resultado[0] : false;
}

function vuelosDisponibles(){
    $sql = "SELECT id_vuelo, id_aerolinea, origen, destino
            FROM vuelos WHERE asientos_disponibles > 0";
    return operarBd($sql);
}

function detallesVuelo($vuelo){
    $sql = "SELECT v.origen origen, v.destino destino, v.fechahorasalida fechahorasalida, v.fechahorallegada fechahorallegada, a.nombre_aerolinea nombre_aerolinea, v.precio_asiento precio_asiento, v.asientos_disponibles asientos_disponibles
            FROM vuelos v
            JOIN aerolineas a ON a.id_aerolinea = v.id_aerolinea
            WHERE id_vuelo = :id_vuelo";
    $valores = ['id_vuelo' => $vuelo];
    return operarBd($sql, $valores)[0];
}

function buscarDni($cliente) {
    $sql = "SELECT dni
              FROM clientes
              WHERE email = :email";
    $args = [':email' => $cliente];

    return operarBd($sql, $args)[0]['dni'];
}

// Función para obtener el ultimo id de reserva
function obtenerUltIdReserva() {
    $sql = "SELECT id_reserva
              FROM reservas
              ORDER BY 1 DESC
              LIMIT 1";
    
    return operarBd($sql)[0]['id_reserva'];
}

// Función para añadir una reserva
function anadirReserva($idReserva, $vuelo, $dni, $asientos, $precio) {
    $sql = "INSERT INTO reservas (id_reserva, id_vuelo, dni_cliente, fecha_reserva, num_asientos, preciototal)
              VALUES (:id_reserva, :id_vuelo, :dni_cliente, NOW(), :num_asientos, :preciototal)";
    $args = [':id_reserva' => $idReserva, ':id_vuelo' => $vuelo, ':dni_cliente' => $dni, ':num_asientos' => $asientos, ':preciototal' => $precio];
  
    return operarBd($sql, $args);
}

// Función para ocupar los asientos de un vuelo
function ocuparAsientos($vuelo, $asientos) {
    $sql = "UPDATE vuelos
              SET asientos_disponibles = asientos_disponibles - :asientos
              WHERE id_vuelo = :id_vuelo";
    $args = [':asientos' => $asientos, ':id_vuelo' => $vuelo];
  
    return operarBd($sql, $args);
}
?>