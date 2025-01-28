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

  function consultarPrecioBase($matricula){
    $sql = "SELECT preciobase
            FROM rvehiculos
            WHERE matricula = :matricula";
    $valores = ['matricula' => $matricula];
    return operarBd($sql, $valores);
  }

  function calcularTiempoAlquilado($matricula){
    $sql = "SELECT TIMESTAMPDIFF(MINUTE, fecha_alquiler, NOW()) AS diferencia_minutos
            FROM ralquileres
            WHERE matricula = :matricula AND fecha_devolucion IS NULL";
    $valores = ['matricula' => $matricula];
    return operarBd($sql, $valores);
  }

  
  
?>