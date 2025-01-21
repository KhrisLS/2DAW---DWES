<?php
  require_once('db/funciones.php');

  function comprobarEmail($email) {
    $sql = "SELECT *
            FROM rclientes
            WHERE email = :email";
    $valores = [':email' => $email];
    
    return operarBd($sql, $valores)[0];
  }
?>