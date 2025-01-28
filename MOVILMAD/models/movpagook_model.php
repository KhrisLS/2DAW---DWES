<?php
  require_once('db/funciones.php');

  function devolverVehiculo($matricula, $precioTotal, $fechaDevolucion){
    $sql = "UPDATE ralquileres 
            SET fecha_devolucion = :fechadevolucion, preciototal = :preciototal, fechahorapago = NOW()
            WHERE matricula = :matricula AND fecha_devolucion IS NULL";
    $valores = ['fechadevolucion' => $fechaDevolucion,'preciototal' => $precioTotal, 'matricula' => $matricula];
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