<?php
  require_once('db/funciones.php');

  function fechaHoraActual(){
    date_default_timezone_set('Europe/Madrid');
    $fecha = date('d-m-Y H:i');
    return $fecha; 
  }

  function vehiculosDisponibles() {
    $sql = "SELECT matricula, marca, modelo
            FROM rvehiculos WHERE disponible ='S'";
    return operarBd($sql);
  }

  function detallesVehiculo($matricula){
    $sql = "SELECT marca, modelo
            FROM rvehiculos 
            WHERE matricula = :matricula";
    $valores = ['matricula' => $matricula];
    return operarBd($sql, $valores);
  }

  function alquilerPorPersona($cliente){
    $sql = "SELECT COUNT(*) AS total_alquileres
            FROM ralquileres 
            WHERE idcliente = :idcliente AND fecha_devolucion IS NULL";
    $valores = ['idcliente' => $cliente];
    return operarBd($sql, $valores);
  }

  function realizarAlquiler($cliente, $matricula){
    $sql = "INSERT INTO ralquileres (idcliente, matricula, fecha_alquiler, fecha_devolucion, preciototal, fechahorapago)
            VALUES (:idcliente, :matricula, NOW(), NULL, NULL, NULL)";
    $valores = ['idcliente' => $cliente, 'matricula' => $matricula];
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