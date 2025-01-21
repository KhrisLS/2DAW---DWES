<?php
  require_once('db/funciones.php');

  function vehiculosDisponibles() {
    $sql = "SELECT matricula, marca, modelo
            FROM rvehiculos WHERE disponible ='S'";
    return operarBd($sql);
  }
?>