<?php
  require_once('db/funciones.php');

  function datosCliente($user) {
    $sql = "SELECT *
            FROM clientes
            WHERE email = :email";
    $valores = [':email' => $user];
    $resultado = operarBd($sql, $valores);

    return $resultado ? $resultado[0] : false;
  }
?>