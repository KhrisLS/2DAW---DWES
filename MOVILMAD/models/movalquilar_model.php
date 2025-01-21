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

  
?>