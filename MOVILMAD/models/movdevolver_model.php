<?php
  require_once('db/funciones.php');

  function vehiculosAlquilados($cliente) {
    $sql = "SELECT r.matricula, v.marca, v.modelo
            FROM ralquileres r
            JOIN rvehiculos v ON r.matricula = v.matricula
            WHERE r.idcliente = :idcliente AND fecha_devolucion IS NULL";
    $valores = ['idcliente' => $cliente];
    return operarBd($sql, $valores);
  }

  function consultarPrecioBaseYFechaAlquiler($matricula){
    $sql = "SELECT v.preciobase, r.fecha_alquiler
            FROM rvehiculos v
            JOIN ralquileres r ON v.matricula = r.matricula
            WHERE v.matricula = :matricula";
    $valores = ['matricula' => $matricula];
    return operarBd($sql, $valores);
  }

  function devolverVehiculo($matricula, $precioBase, $fechaAlquiler){
    $sql = "UPDATE ralquileres 
            SET fecha_devolucion = NOW(), preciototal = :preciobase * TIMESTAMPDIFF(MINUTE, :fecha_alquiler, NOW()), fechahorapago = NOW()
            WHERE matricula = :matricula";
    $valores = ['preciobase' => $precioBase, 'fecha_alquiler' => $fechaAlquiler, 'matricula' => $matricula];
    return operarBD($sql, $valores);
  }

  function actualizarDisponibilidadVehiculo($matricula, $disponible) {
    $sql = "UPDATE rvehiculos
            SET disponible = :disponible
            WHERE matricula = :matricula";
    $args = [':matricula' => $matricula, ':disponible' => $disponible];
    return operarBd($sql, $args);
  }
  
?>