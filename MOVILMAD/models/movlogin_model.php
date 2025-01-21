<?php
  require_once('db/funciones.php');

  //buscar cliente por su EMAIL
  function comprobarEmail($email) {
    $sql = "SELECT *
            FROM rclientes
            WHERE email = :email";
    $valores = [':email' => $email];
    
    return operarBd($sql, $valores)[0];
  }
?>