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

// Función para obtener el dni de un cliente por su email
function buscarDni($cliente) {
    $sql = "SELECT dni
              FROM clientes
              WHERE email = :email";
    $args = [':email' => $cliente];

    return operarBd($sql, $args)[0]['dni'];
  }

// Función para obtener las reservas hechas por un cliente
function obtenerReservas($dni) {
    $sql = "SELECT DISTINCT id_reserva
              FROM reservas
              WHERE dni_cliente = :dni_cliente";
    $args = [':dni_cliente' => $dni];

    return operarBd($sql, $args);
  }

// Función para obtener los datos de los vuelos de una reserva
function datosVuelosReserva($reserva) {
    $sql = "SELECT a.nombre_aerolinea nombre_aerolinea, v.origen origen, v.destino destino, v.fechahorasalida fechahorasalida, v.fechahorallegada fechahorallegada, r.num_asientos num_asientos
              FROM reservas r
              JOIN vuelos v ON v.id_vuelo = r.id_vuelo
              JOIN aerolineas a ON a.id_aerolinea = v.id_aerolinea
              WHERE id_reserva = :id_reserva";
    $args = [':id_reserva' => $reserva];

    return operarBd($sql, $args);
  }

?>