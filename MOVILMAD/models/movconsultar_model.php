<?php
  require_once('db/funciones.php');

  function listaAlquilerTotal($cliente) {
    $sql = "SELECT r.matricula, v.marca, v.modelo, r.fecha_alquiler, r.fecha_devolucion, r.preciototal
            FROM ralquileres r
            JOIN rvehiculos v ON r.matricula = v.matricula
            WHERE r.idcliente = :idcliente
            ORDER BY r.fecha_alquiler";
    $valores = [':idcliente' => $cliente];
    return operarBd($sql, $valores);
  }

  function listaAlquilerPorFecha($cliente, $fechaDesde, $fechaHasta) {
    $sql = "SELECT r.matricula, v.marca, v.modelo, r.fecha_alquiler, r.fecha_devolucion, r.preciototal
            FROM ralquileres r
            JOIN rvehiculos v ON r.matricula = v.matricula
            WHERE r.idcliente = :idcliente AND r.fecha_alquiler BETWEEN :fechaDesde AND :fechaHasta
            ORDER BY r.fecha_alquiler";
    $valores = [':idcliente' => $cliente,':fechaDesde' => $fechaDesde, ':fechaHasta' => $fechaHasta];
    return operarBd($sql, $valores);
  }

  
?>