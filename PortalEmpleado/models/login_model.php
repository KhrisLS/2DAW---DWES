<?php
  require_once('db/funciones.php');

  function comprobarUser($user) {
    $sql = "SELECT *
            FROM employees
            WHERE emp_no = :emp_no";
    $valores = [':emp_no' => $user];
    return operarBd($sql, $valores)[0];
  }

  function comprobarDepartamento($user) {
    $sql = "SELECT dept_no
            FROM dept_emp
            WHERE emp_no = :emp_no";
    $valores = [':emp_no' => $user];
    return operarBd($sql, $valores)[0];
  }
?>