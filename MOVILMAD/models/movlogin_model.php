<?php
  require_once('db/funciones.php');

  //buscar cliente por ID
  function buscarCliente($cliente) {
    $sql = "SELECT *
            FROM rclientes
            WHERE idcliente = :idcliente";
    $valores = [':idcliente' => $cliente];
    
    return operarBd($sql, $valores)[0];
  }

  //buscar cliente por su EMAIL
  function buscarEmail($email) {
    $sql = "SELECT *
            FROM rclientes
            WHERE email = :email";
    $valores = [':email' => $email];
    
    return operarBd($sql, $valores)[0];
  }
?>